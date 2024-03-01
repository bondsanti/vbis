<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportLogin extends Model
{
    protected $connection = 'mysql_report';
    protected $table = 'log_login';
}
