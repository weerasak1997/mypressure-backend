<?php

namespace App\Models;

use App\Models\Product;
use App\Models\UserInfo;
use App\Models\StockHistory;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'dob', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    function StockHistory()
    {
        return $this->HasOne(StockHistory::class, 'user_id', 'id')->orderBydesc(
            'id'
        );
    }
    public function sendPasswordResetNotification($token)
    {
        $data = [$this->email];
        $emailShow = explode('@', $this->email);
        $emailShow =
            substr($emailShow[0], 0, 3) .
            '**' .
            substr($emailShow[0], strlen($emailShow[0]) - 1, 1) .
            '@' .
            $emailShow[1];
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = 'https://';
        } else {
            $url = 'http://';
        }
        $url .= $_SERVER['HTTP_HOST'];
        Mail::send(
            'email.reset-password',
            [
                'name' => $this->username,
                'emailShow' => $emailShow,
                'fullname' => $this->fullname,
                'reset_url' =>
                    $url .
                    '/password/reset/' .
                    $token .
                    '?email=' .
                    $this->email,
            ],
            function ($m) use ($data) {
                $m->from('law.woftspirit@gmail.com', 'Dinero');
                $m
                    ->to($this->email, 'admin')
                    ->subject('Your Reset Password Email!');
            }
        );
    }
    public function UserInfo(){
        return $this->hasOne(UserInfo::class,'user_id','id');
    }
    public function GetName(){
        return $this->UserInfo->firstname.' '.$this->UserInfo->lastname;
    }
    public function Product(){
        return $this->hasMany(Product::class,'user_id','id');
    }
    public function ProductOne(){
        return $this->hasOne(Product::class,'user_id','id')->orderByDesc('id');
    }
}
