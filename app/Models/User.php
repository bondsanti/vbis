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


    public function role_report_ref(){

        return $this->hasOne(RoleReport::class, 'code_user', 'code');
    }
    public function role_report_refdb(){

        return $this->hasOne(RoleReport::class, 'code_user', 'code');
    }

    public function role_printer_ref(){

        return $this->hasOne(RolePrinter::class, 'user_id', 'user_id');
    }

    public function role_rental_ref(){

        return $this->hasOne(RoleRental::class, 'user_id', 'user_id');
    }

    public function role_boker_ref(){

        return $this->hasOne(RoleBoker::class, 'user_id', 'user_id');
    }
}
