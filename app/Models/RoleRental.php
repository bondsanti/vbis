<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRental extends Model
{
    use HasFactory;
    protected $connection = 'mysql_rental';
    protected $table = 'role_users';

    protected $fillable = [
        'id', 'user_id','role_type',
    ];
}
