<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'tb_department';
    public function user_ref()
    {

        return $this->belongsTo(User::class, 'department_id', 'id');
    }
}
