<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'model_has_roles';
    protected $fillable = ['model_id', 'role_id', 'model_type'];
    public $timestamps = false;
    use HasFactory;
}
