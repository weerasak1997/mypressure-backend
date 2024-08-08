<?php

namespace App\Console\Commands;

use App\Models\UserBet;
use App\Models\EachRound;
use App\Models\UserAccount;
use App\Models\BotManagement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Bot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:bot';

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
        sleep(15);
        /*try {
         DB::beginTransaction();*/
        $each = EachRound::orderByDesc('id')
            ->skip(1)
            ->first();
        $arrayIsExist = null;
        $count = UserAccount::first();
        if (!$count) {
            $count = new UserAccount();
            $count->account = '0xAbCd2dF5C71d8f5A87616a861950934F7e6F0B30';
            $count->agreement = true;
            $count->last_login = date('Y-m-d H:i:s');
            $count->amount = 0;
            $count->save();
        }
        $find = UserAccount::where('account', 'bot1@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot1@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [1];
                } else {
                    array_push($arrayIsExist, 1);
                }
            }
        }
        $find = UserAccount::where('account', 'bot2@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot2@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [2];
                } else {
                    array_push($arrayIsExist, 2);
                }
            }
        }
        $find = UserAccount::where('account', 'bot3@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot3@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [3];
                } else {
                    array_push($arrayIsExist, 3);
                }
            }
        }
        $find = UserAccount::where('account', 'bot4@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot4@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [4];
                } else {
                    array_push($arrayIsExist, 4);
                }
            }
        }
        $find = UserAccount::where('account', 'bot5@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot5@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [5];
                } else {
                    array_push($arrayIsExist, 5);
                }
            }
        }
        $find = UserAccount::where('account', 'bot6@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot6@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [6];
                } else {
                    array_push($arrayIsExist, 6);
                }
            }
        }
        $find = UserAccount::where('account', 'bot7@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot7@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [7];
                } else {
                    array_push($arrayIsExist, 7);
                }
            }
        }
        $find = UserAccount::where('account', 'bot8@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot8@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [8];
                } else {
                    array_push($arrayIsExist, 8);
                }
            }
        }
        $find = UserAccount::where('account', 'bot9@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot9@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [9];
                } else {
                    array_push($arrayIsExist, 9);
                }
            }
        }
        $find = UserAccount::where('account', 'bot10@bot.cobot')->first();
        if (!$find) {
            $find = new UserAccount();
            $find->account = 'bot10@bot.cobot';
            $find->agreement = true;
            $find->last_login = date('Y-m-d H:i:s');
            $find->amount = 0;
            $find->save();
        } else {
            $bet = UserBet::where('user_account_id', $find->id)
                ->where('each_round_id', $each->id)
                ->first();
            if (
                $bet ||
                !($find->BotManagement ? $find->BotManagement->enabled : true)
            ) {
                if ($arrayIsExist === null) {
                    $arrayIsExist = [10];
                } else {
                    array_push($arrayIsExist, 10);
                }
            }
        }
        if (count($arrayIsExist === null ? [] : $arrayIsExist) < 10) {
            $myArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            $arrayUse = null;
            if ($arrayIsExist !== null) {
                $arrayUse = array_diff($myArray, $arrayIsExist);
            } else {
                $arrayUse = $myArray;
            }
            $arrayRealUse = null;
            foreach (array_keys($arrayUse) as $use) {
                if ($arrayRealUse !== null) {
                    array_push($arrayRealUse, $arrayUse[$use]);
                } else {
                    $arrayRealUse = [$arrayUse[$use]];
                }
            }
            $ran = 2;
            if ($arrayRealUse !== null) {
                if (count($arrayRealUse) < 2) {
                    $arrayRand = $arrayRealUse;
                } else {
                    $arrayRand = array_rand(
                        $arrayRealUse === null ? $myArray : $arrayRealUse,
                        $ran
                    );
                }
            }
            $userId = UserAccount::whereIn('account', [
                'bot' .
                ($arrayRealUse === null ? $myArray : $arrayRealUse)[
                    count($arrayRand) < 2 ? 0 : $arrayRand[0]
                ] .
                '@bot.cobot',
                'bot' .
                ($arrayRealUse === null ? $myArray : $arrayRealUse)[
                    count($arrayRand) < 2 ? 0 : $arrayRand[1]
                ] .
                '@bot.cobot',
            ])->get();
            foreach ($userId as $key => $user) {
                if ($user->amount > 0) {
                    if ($key !== 0) {
                        $wait = (int) ceil(rand(15, 25));
                        sleep($wait);
                    }
                    if ($user->BotManagement) {
                        $min =
                            ($user->amount * $user->BotManagement->min) / 100;
                        $max =
                            ($user->amount * $user->BotManagement->max) / 100;
                        if ($min < 1) {
                            if ($user->amount >= 1) {
                                $min = 1;
                            } else {
                                $min = 0;
                            }
                        }
                        if ($max < 1) {
                            if ($user->amount >= 1) {
                                $max = 1;
                            } else {
                                $max = 0;
                            }
                        }
                        $ce = rand($min, $max);
                        $amount = ceil($ce);
                        if($amount>0){
                            $userB = new UserBet();
                            $userB->each_round_id = $each->id;
                            $userB->user_account_id = $user->id;
                            $userB->amount = $amount;
                            $userB->total = $user->amount - $amount;
                            if ($user->BotManagement->type == 'ขึ้นเท่านั้น') {
                                $userB->way = 1;
                            } elseif ($user->BotManagement->type == 'ลงเท่านั้น') {
                                $userB->way = 2;
                            } elseif ($user->BotManagement->type == 'สลับ') {
                                if ($user->BotManagement->way == 'ขึ้น') {
                                    $mana = BotManagement::find(
                                        $user->BotManagement->id
                                    );
                                    $userB->way = 2;
                                    $mana->way = 2;
                                    $mana->update();
                                } else {
                                    $mana = BotManagement::find(
                                        $user->BotManagement->id
                                    );
                                    $userB->way = 1;
                                    $mana->way = 1;
                                    $mana->update();
                                }
                            } else {
                                $way = (int) round(rand(0, 1));
                                $userB->way = $way + 1;
                            }
                            $userB->save();
                            $user->amount = $user->amount - $amount;
                            $user->update();
                        }
                    } else {
                        $min = ($user->amount * 1) / 100;
                        $max = ($user->amount * 1) / 100;
                        if ($min < 1) {
                            if ($user->amount >= 1) {
                                $min = 1;
                            } else {
                                $min = 0;
                            }
                        }
                        if ($max < 1) {
                            if ($user->amount >= 1) {
                                $max = 1;
                            } else {
                                $max = 0;
                            }
                        }
                        $ce = rand($min, $max);
                        $amount = ceil($ce);
                        if($amount>0){
                            $userB = new UserBet();
                            $userB->each_round_id = $each->id;
                            $userB->user_account_id = $user->id;
                            $userB->amount = $amount;
                            $userB->total = $user->amount - $amount;
                            $way = (int) round(rand(0, 1));
                            $userB->way = $way + 1;
                            $userB->save();
                            $user->amount = $user->amount - $amount;
                            $user->update();
                        }
                    }
                }
            }
        }
        /*   DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back();
        }*/
    }
}
