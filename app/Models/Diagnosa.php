<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;
    protected $fillable =[
        'hasil_diagnosa',
        'presentase',
        'id_gejala',
        'id_level',
    ];
    protected $table = 'table_diagnosa';
    public function gejala()
    {
        return $this->belongsTo('App\Models\Gejala', 'id_gejala', 'id');
    }
    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'id_level', 'id');
    }
}
