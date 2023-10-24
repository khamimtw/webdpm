<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pertanyaan;
use App\Models\jawaban;
use Illuminate\Support\Facades\DB;

class pakarJawabanController extends Controller
{
    public function index()
    {
        $unansweredQuestions = DB::table('pertanyaan')
        ->leftJoin('jawaban', 'pertanyaan.id', '=', 'jawaban.pertanyaan_id')
        ->whereNull('jawaban.id') // Pertanyaan yang belum dijawab
        ->select('pertanyaan.nama', 'pertanyaan.pertanyaan','pertanyaan.id')
        ->get();

    $answeredQuestions = DB::table('pertanyaan')
        ->join('jawaban', 'pertanyaan.id', '=', 'jawaban.pertanyaan_id')
        ->select('pertanyaan.nama', 'pertanyaan.pertanyaan', 'jawaban.jawaban', 'pertanyaan.id')
        ->get();
        return view('pakar.jawabanPakar', compact('unansweredQuestions', 'answeredQuestions'));
    }

    public function show(pertanyaan $question)
    {
        return view('admin.questions.show', compact('question'));
    }

    public function answer(Request $request, pertanyaan $question, $id)
    {
        $this->validate($request, [
            'jawaban' => 'required',
        ]);

        $answer = new jawaban([
            'jawaban' => $request->input('jawaban'),
            'pertanyaan_id' => $id,
        ]);

        $answer->save();

        return redirect()->back()
            ->with('success', 'Jawaban berhasil ditambahkan');
    }
    public function updateAnswer(Request $request, $id)
{
    $this->validate($request, [
        'editedAnswer' => 'required',
    ]);

    $item = jawaban::findOrFail($id);
    $item->jawaban = $request->input('editedAnswer');
    $item->save();

    return redirect()->back()
            ->with('success', 'Jawaban berhasil diubah');
    // Redirect atau berikan respons sesuai kebutuhan Anda
}
public function destroy($id)
    {
        DB::table('pertanyaan')->where('id', '=', $id)->delete();
        DB::table('jawaban')->where('pertanyaan_id', '=', $id)->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}
