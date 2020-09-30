<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ユーザーとフォルダの関係性
    public function folders()
    {
        // リレーション:1対多の関係 $thisからフォルダにアクセスできる
        return $this->hasMany('App\Folder');
    }

    /**
     * パスワード再設定メールを送信
     */
    public function sendPasswordResetNotification($token)
    {
        //app/Mailに作成したResetPasswordクラスが使われるように設定する
        Mail::to($this)->send(new ResetPassword($token));
    }

}
