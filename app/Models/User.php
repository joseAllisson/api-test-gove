<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'name',
    'email',
    'phone',
    'last_login',
    'user_type',
    'sector',
  ];
  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
  ];

  public function permissions()
  {
    return $this->belongsToMany(Permission::class)->whereNotNull('parent_id');
  }

  // public function childPermissions()
  // {
  //   return $this->belongsToMany(Permission::class)->whereNotNull('parent_id');
  // }
}
