<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_position';

    public function user_ref()
    {

        return $this->belongsTo(User::class, 'position_id', 'id');
    }
}
