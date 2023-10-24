<?php

namespace App\Http\Controllers;

use App\Models\pertanyaan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class pertanyaanController extends Controller
{
    public function pertanyaan()
    {
        return view('user.Pertanyaan');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'pertanyaan' => 'required',
        ]);

        pertanyaan::create([
            'nama' => $request->nama,
            'jenis_kelamin'=>$request->jenis_kelamin,
            'pertanyaan' => $request->pertanyaan,
        ]);

        return redirect()->back()->with('success', 'Pertanyaan berhasil disimpan');
    }

    public function show($id)
    {
        $question = pertanyaan::findOrFail($id);
        return view('questions.show', compact('question'));
    }

}
