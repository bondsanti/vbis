<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'logs';

    protected $fillable = ['user_id', 'action', 'description','ip'];

    public static function addLog($id, $action, $description, $ip = null)
    {
        if (is_null($ip)) {
            $ip = request()->ip();
        }

        self::create([
            'user_id' => $id,
            'action' => $action,
            'description' => $description,
            'ip' => $ip,
        ]);
    }
}
