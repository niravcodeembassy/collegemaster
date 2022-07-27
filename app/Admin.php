<?php

namespace App;

use App\Notifications\Admin\Auth\ResetPassword;
use App\Notifications\Admin\Auth\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable implements MustVerifyEmail
{
  use Notifiable;
  use HasRoles;
  use SoftDeletes;

  public static $guard_name = "web";

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token', 'name'
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
   * Send the password reset notification.
   *
   * @param  string  $token
   * @return void
   */
  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  /**
   * Send the email verification notification.
   *
   * @return void
   */
  public function sendEmailVerificationNotification()
  {
    $this->notify(new VerifyEmail);
  }

  public function setPasswordAttribute($password): void
  {
    // If password was accidentally passed in already hashed, try not to double hash it
    if (
      (\strlen($password) === 60 && preg_match('/^\$2y\$/', $password)) ||
      (\strlen($password) === 95 && preg_match('/^\$argon2i\$/', $password))
    ) {
      $hash = $password;
    } else {
      $hash = Hash::make($password);
    }

    $this->attributes['password'] = $hash;
  }

  public function setNameAttribute($name): void
  {
    $this->attributes['name'] = $this->first_name . ' ' . $this->last_name;
  }

  /**
   * @return string
   */
  public function getFullNameAttribute()
  {
    return $this->last_name ? $this->first_name . ' ' . $this->last_name : $this->first_name;
  }



  public function getProfileSrcAttribute()
  {
    $imageExist  =  Storage::disk('public')->exists($this->profile_image);

    if ($imageExist && $this->profile_image != NULL && $this->profile_image != "") {
      return asset('storage/' . $this->profile_image);
    }

    return asset('storage/default/default.png');
  }
}
