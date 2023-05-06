<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAbilities(){
        $permissions = $this->getAllPermissions();
        $i = 0;
        foreach($permissions as $permission){
            $name = $permission->name;
            $ability = explode('-', $name);
            $action = $ability[0];
            $resource = $ability[1];
            $permissions[$i]->action = $action;
            $permissions[$i]->resource = $resource;
            $i++;
        }

        return $permissions;
    }

    public function getAbilitiesName(){
        $permissions = $this->getAllPermissions();
        $permissionsName = [];
        $i = 0;
        foreach($permissions as $permission){
            $permissionsName[$i] = $permission->name;
            $i++;
        }
        return $permissionsName;
    }
}
