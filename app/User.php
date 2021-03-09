<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $guard_name = 'api';

    protected $attributes = [
        'name' => '',
        'surname' => '',
        'patronymic' => '',
        'phone' => '',
        'company_id' => 0
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function projects() {
        return $this->hasMany('App\Models\Project', 'manager_id', 'id');
    }
}
