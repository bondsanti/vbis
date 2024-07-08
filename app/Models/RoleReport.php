<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleReport extends Model
{
    protected $connection = 'mysql_report';
    protected $table = 'user';
    public $timestamps= false;
    protected $primaryKey = 'code_user';
    protected $fillable = ['code_user','password','level','db'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'code_user', 'code');
    }
}
