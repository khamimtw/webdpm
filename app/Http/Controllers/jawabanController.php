<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jawaban;
use App\Models\pertanyaan;
use Illuminate\Support\Facades\DB;

class jawabanController extends Controller
{
    public function index()
    {
        $unansweredQuestions = DB::table('pertanyaan')
        ->leftJoin('jawaban', 'pertanyaan.id', '=', 'jawaban.pertanyaan_id')
        ->whereNull('jawaban.id') // Pertanyaan yang belum dijawab
        ->select('pertanyaan.nama', 'pertanyaan.pertanyaan')
        ->get();

    $answeredQuestions = DB::table('pertanyaan')
        ->join('jawaban', 'pertanyaan.id', '=', 'jawaban.pertanyaan_id')
        ->select('pertanyaan.nama', 'pertanyaan.pertanyaan', 'jawaban.jawaban')
        ->get();
        return view('user.lihatJawaban', compact('unansweredQuestions', 'answeredQuestions'));
    }

}
