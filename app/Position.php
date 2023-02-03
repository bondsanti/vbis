<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'tb_position';
    public function user_ref()
    {

        return $this->belongsTo(User::class, 'position_id', 'id');
    }
}
