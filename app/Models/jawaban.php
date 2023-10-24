<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jawaban extends Model
{
    use HasFactory;
    protected $fillable = ['jawaban', 'pertanyaan_id'];
    protected $table = 'jawaban';
    public function pertanyaan()
    {
        return $this->belongsTo(pertanyaan::class);
    }
}
