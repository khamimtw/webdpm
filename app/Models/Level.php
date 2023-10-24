<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_penyakit'
    ];
    protected $table = 'table_level';
    public function diagnosa() {
        return $this->hasMany(Diagnosa::class);
    }
}
