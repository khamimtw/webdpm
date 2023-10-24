<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengobatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengobatan',
        'level_penyakit'
    ];
    protected $table = 'table_pengobatan';

    public function level(){
        return $this->belongsTo('App\Models\Level', 'level_penyakit', 'id');
    }
}
