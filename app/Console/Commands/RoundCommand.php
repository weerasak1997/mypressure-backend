<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserBet;
use App\Models\EachRound;
use App\Models\ProfitUser;
use App\Models\UserAccount;
use App\Models\UserDeposit;
use App\Models\UserPayment;
use Illuminate\Console\Command;
use App\Models\UserAccountProfit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RoundCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:round';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $round = EachRound::first();
            if ($round) {
                $time = date('Y-m-d H:i:s', strtotime('+1 minutes'));
                $response = Http::get(
                    'https://admin.wolfspirit.tech/api/get/price/show'
                );
                $price = json_decode($response->body())->price;
                $round = EachRound::orderByDesc('id')
                    ->skip(1)
                    ->first();
                $round->start_price = $price;
                $round->start_date = $time;
                $round->update();
                $payment = UserPayment::where('status', 'pending')
                    ->orWhere(function ($q) {
                        return $q
                            ->where('status', 'cancel')
                            ->where(
                                'user_payments.id',
                                '>',
                                DB::raw(
                                    '(select up.id from user_payments as up where up.status="success" and up.user_account_id = user_payments.user_account_id ORDER BY id desc limit 1)'
                                )
                            );
                    })
                    ->orWhere(function ($q) {
                        return $q
                            ->where('status', 'cancel')
                            ->where(
                                'user_payments.id',
                                '>',
                                DB::raw(
                                    '(select up.id from user_payments as up where up.status="success" and up.user_id = user_payments.user_id ORDER BY id desc limit 1)'
                                )
                            );
                    })
                    ->get();
                $get = Http::post(
                    (env('LOCATION') === 'SERVER'
                        ? 'https://node.wolfspirit.tech/'
                        : 'http://127.0.0.1:3001/') . 'getTransaction',
                    ['id' => array_column($payment->toArray(), 'id')]
                );
                $data = json_decode($get->body());
                if ($data) {
                    foreach ($payment ?? [] as $item) {
                        $update = false;
                        foreach ($data as $key => $transaction) {
                            $user = null;
                            $total = 0;
                            if ($item->id === (int) $transaction[0]) {
                                if ($item->type === 'deposit') {
                                    $account = UserAccount::where(
                                        'account',
                                        $transaction[1]
                                    )->first();
                                    $account->amount +=
                                        (float) ($transaction[3] / pow(10, 18));
                                    $account->update();
                                    $total = $account->amount;
                                } else {
                                    if ($item->user_id) {
                                        $user = User::find($item->user_id);
                                        if ($item->is_return === 1) {
                                            $user->withdraw_avilable -=
                                                (float) ($transaction[3] /
                                                    pow(10, 18));
                                        }
                                        $user->update();
                                        $total = $user->withdraw_avilable;
                                    } else {
                                        $account = UserAccount::where(
                                            'account',
                                            $transaction[2]
                                        )->first();
                                        if (!$account) {
                                            $account = new UserAccount();
                                            $account->account = $transaction[2];
                                            $account->amount = 0;
                                            $account->save();
                                        } else {
                                            if ($item->is_return === 1) {
                                                $account->amount -=
                                                    (float) ($transaction[3] /
                                                        pow(10, 18));
                                            }
                                            $account->update();
                                        }
                                        $total = $account->amount;
                                    }
                                }
                                $update = true;
                                $item->amount =
                                    (float) ($transaction[3] / pow(10, 18));
                                $item->status = 2;
                                $item->total = $total;
                                $item->update();
                                break;
                            }
                        }
                        if (!$update && $item->status === 'pending') {
                            $item->is_return = true;
                            if ($item->type === 'withdraw') {
                                if ($item->user_account_id) {
                                    $account = UserAccount::find(
                                        $item->user_account_id
                                    );
                                    $account->amount += (float) $item->amount;
                                    $account->update();
                                } else {
                                    $account = User::find($item->user_id);
                                    $account->withdraw_avilable +=
                                        (float) $item->amount;
                                    $account->update();
                                }
                            }
                            $item->status = 3;
                            $item->update();
                        }
                    }
                } else {
                    foreach ($payment ?? [] as $item) {
                        if (
                            $item->type === 'withdraw' &&
                            $item->status === 'pending'
                        ) {
                            $item->is_return = true;
                            if ($item->user_account_id) {
                                $account = UserAccount::find(
                                    $item->user_account_id
                                );
                                $account->amount += (float) $item->amount;
                                $account->update();
                            } else {
                                $account = User::find($item->user_id);
                                $account->withdraw_avilable +=
                                    (float) $item->amount;
                                $account->update();
                            }
                        }
                        $item->status = 3;
                        $item->update();
                    }
                }
                //calculate
                $calculate = EachRound::orderByDesc('id')
                    ->skip(2)
                    ->first();
                if ($calculate) {
                    $way =
                        (float) $price > $calculate->start_price
                            ? 1
                            : ((float) $price === $calculate->start_price
                                ? 3
                                : 2);
                    $pool = 0;
                    $upMulti = 0;
                    $downMulti = 0;
                    foreach ($calculate->UserBet as $item) {
                        $pool += $item->amount;
                        if ($item->way === 'up') {
                            $upMulti += $item->amount;
                        } else {
                            $downMulti += $item->amount;
                        }
                    }
                    $upValue = $upMulti;
                    $downValue = $downMulti;
                    if ($upMulti == 0) {
                        $upMulti = 1;
                    }
                    if ($downMulti == 0) {
                        $downMulti = 1;
                    }
                    $profit = 0;
                    if ($way == 1) {
                        if ($downValue != 0) {
                            $multiplier =
                                $upMulti == 0
                                    ? 1
                                    : (float) number_format(
                                        ((($downMulti * 90) / 100 + $upMulti) *
                                            90) /
                                            100 /
                                            ($upMulti != 0 ? $upMulti : 1),
                                        4,
                                        '.',
                                        ''
                                    );
                        } else {
                            $multiplier = 1;
                        }
                        // $multiplier = (( $upMulti * 80) / 100) / ($downMulti !== 0 ? $downMulti : 1);
                        if ($upValue == 0) {
                            $profit = $downValue;
                        } else {
                            $profit =
                                $downValue * (10 / 100) +
                                ($downValue * (90 / 100) + $upMulti) *
                                    (10 / 100);
                        }
                    } elseif ($way == 2) {
                        if ($upValue != 0) {
                            $multiplier =
                                $downMulti == 0
                                    ? 1
                                    : (float) number_format(
                                        ((($upMulti * 90) / 100 + $downMulti) *
                                            90) /
                                            100 /
                                            ($downMulti != 0 ? $downMulti : 1),
                                        4,
                                        '.',
                                        ''
                                    );
                        } else {
                            $multiplier = 1;
                        }
                        // $profit = $downMulti;
                        if ($downValue == 0) {
                            $profit = $upValue;
                        } else {
                            $profit =
                                $upValue * (10 / 100) +
                                ($upValue * (90 / 100) + $downMulti) *
                                    (10 / 100);
                        }
                    } else {
                        $multiplier = 1;
                    }
                    if ($multiplier < 1) {
                        $multiplier = 1;
                    }
                    $calculate->way = $way;
                    $calculate->multiplier = $multiplier;
                    $calculate->profit = $profit;
                    $calculate->end_price = $price;
                    $calculate->update();
                    if ($profit !== 0) {
                        $users = User::whereIn('role', ['admin', 'superadmin'])
                            ->has('StockHistory')
                            ->get();
                        foreach ($users as $user) {
                            $getProfit =
                                $profit *
                                ($user->StockHistory->sharing_stock / 100);
                            $user->withdraw_avilable += $getProfit;
                            $userPro = new ProfitUser();
                            $userPro->user_id = $user->id;
                            $userPro->each_round_id = $calculate->id;
                            $userPro->profit = $getProfit;
                            $userPro->save();
                            $user->update();
                        }
                    }
                    $users = UserAccount::whereHas('UserBet', function (
                        $q
                    ) use ($calculate) {
                        return $q->where('each_round_id', $calculate->id);
                    })->get();
                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            $bet = UserBet::where(
                                'each_round_id',
                                $calculate->id
                            )
                                ->where('user_account_id', $user->id)
                                ->first();
                            if (
                                $bet->way ===
                                ($calculate->way === 1 ? 'up' : 'down')
                            ) {
                                $each = UserBet::where(
                                    'each_round_id',
                                    $calculate->id
                                )
                                    ->where('way', '!=', $bet->way)
                                    ->sum('amount');
                                if ($each > 0) {
                                    $profit = $bet->amount * $multiplier;
                                    $user->amount += (float) number_format(
                                        $profit,
                                        2,
                                        '.',
                                        ''
                                    );
                                    $user->update();
                                    $history = new UserAccountProfit();
                                    $history->user_account_id = $user->id;
                                    $history->each_round_id = $calculate->id;
                                    $history->profit = $profit - $bet->amount;
                                    $history->total = $user->amount;
                                    $history->save();
                                } else {
                                    $user->amount += $bet->amount;
                                    $user->update();
                                    $history = new UserAccountProfit();
                                    $history->user_account_id = $user->id;
                                    $history->each_round_id = $calculate->id;
                                    $history->profit = $bet->amount;
                                    $history->total = $user->amount;
                                    $history->save();
                                }
                            }
                        }
                    }
                }
                $roundNew = new EachRound();
                $count = EachRound::whereDate('start_date', date('Y-m-d'))
                    ->get()
                    ->count();
                $roundNew->name = 'BTC ' . date('Y-m-d') . ' R:' . ($count + 1);
                // $roundNew->start_date = date('Y-m-d H:i:s',strtotime('+1 minutes'));
                // $round->start_price = $price;
                $roundNew->save();
            } else {
                $response = Http::get(
                    'https://admin.wolfspirit.tech/api/get/price/show'
                );
                $price = json_decode($response->body())->price;
                $roundEnd = new EachRound();
                $roundEnd->name = 'BTC ' . date('Y-m-d') . ' R:1';
                $roundEnd->start_date = date('Y-m-d H:i:s');
                $roundEnd->start_price = $price;
                $roundEnd->save();
                $roundAfter = new EachRound();
                $roundAfter->name = 'BTC ' . date('Y-m-d') . ' R:2';
                // $roundAfter->start_date = date('Y-m-d H:i:s',strtotime('minutes'));
                $roundAfter->save();
                $roundAfter = new EachRound();
                $roundAfter->name = 'BTC ' . date('Y-m-d') . ' R:3';
                // $roundAfter->start_date = date('Y-m-d H:i:s',strtotime('minutes'));
                $roundAfter->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back();
        }
        // $user = UserDeposit::where('status','pending')->get();
        // if(count($user)>0){
        //     echo json_encode($user);
        // }
    }
}
