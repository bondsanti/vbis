<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $connection = 'mysql';
    protected $table = 'users';

    public $timestamps= false;
    // protected $fillable = ['is_auth','token_forget'];

    public function position_ref(){
        return $this->hasOne(Position::class, 'id', 'position_id');
    }
    public function department_ref()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}
