<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePrinter extends Model
{
    protected $connection = 'mysql_printer';
    protected $table = 'role_user';

    protected $fillable = [
        'id', 'user_id','role_type',
    ];
}
