<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level'
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
   
  /**
   * Has One User -> Spp
   *
   * @return void
   */
    public function spp()
    {
         return $this->hasOne(Spp::class);
    }
   
  /**
   * Has One User -> Kelas
   *
   * @return void
   */
    public function kelas()
    {
         return $this->hasOne(Kelas::class);
    }
   
 /**
   * Belongs To Pembayaran -> User (petugas)
   *
   * @return void
   */
    public function pembayaran()
    {
         return $this->hasMany(Pembayaran::class);
    }
}
