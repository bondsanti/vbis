<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql';
    protected $table = 'users';

    public $timestamps= false;
    protected $fillable = ['id','user_id','code','old_code','created_date','email','username','password','old_password'];

    // public function position_ref(){
    //     return $this->hasOne(Position::class, 'id', 'position_id');
    // }
    // public function department_ref()
    // {
    //     return $this->hasOne(Department::class, 'id', 'department_id');
    // }

    public function role_report_ref(){

        return $this->hasOne(RoleReport::class, 'code_user', 'code');
    }
    public function role_printer_ref(){

        return $this->hasOne(RolePrinter::class, 'user_id', 'id');
    }
}
