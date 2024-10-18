<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class MstUser extends Authenticatable
{
    protected $table = 'mst_users';

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    protected $fillable = ['name', 'email', 'password', 'group_role', 'is_delete'];

    public function getLastLoginAtAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('Y-m-d');
        }

        return null; 
    }
    
}
