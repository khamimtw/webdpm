<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormalizedData extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute1',
        'attribute2',
        'attribute3',
        // Tambahkan kolom lain sesuai kebutuhan Anda
    ];
}
