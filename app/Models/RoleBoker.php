<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleBoker extends Model
{
    use HasFactory;
    protected $connection = 'mysql_broker';
    protected $table = 'role_user';

    protected $fillable = [
        'id', 'user_id','role_type',
    ];
}
