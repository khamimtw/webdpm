<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pertanyaan extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'jenis_kelamin', 'pertanyaan'];
    protected $table = 'pertanyaan';
    public function jawaban()
    {
        return $this->hasMany(jawaban::class);
    }
}
