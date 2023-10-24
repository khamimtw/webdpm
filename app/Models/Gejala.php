<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;
    protected $fillable = [
        'umur',
        'jenis_kelamin',
        'kehamilan',
        'TSH',
        'T3',
        'TT4',
        'update_at',
        'created_at'
    ];
    protected $table = 'table_gejala';
}
