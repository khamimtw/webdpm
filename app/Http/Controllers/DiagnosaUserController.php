<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use Illuminate\Http\Request;
use App\Models\ANN;
use App\Models\Gejala;
use RealRashid\SweetAlert\Facades\Alert;

class DiagnosaUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diagnosa = Diagnosa::latest()
    ->join('table_gejala', 'table_diagnosa.id_gejala', '=', 'id')
    ->join('table_level', 'table_diagnosa.id_level', '=', 'table_level.id')
    ->select('table_diagnosa.*', 'table_gejala.umur', 'table_gejala.jenis_kelamin', 'table_level.level_penyakit') // Anda bisa memilih kolom yang ingin Anda ambil
    ->get();
        return view('user.hasil', compact('diagnosa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.diagnosa');
    }

    private function minMaxNormalization($attributes)
    {
        // Tentukan nilai minimum dan maksimum dari data latih
        $minVals = [0, 0, 0, 0, 0, 0, 0];
        $maxVals = [92, 1, 1, 260, 18, 430, 1];
        $normalizedData = [];
        foreach ($attributes as $row) {
            $normalizedRow = [];
            $normalizedRow['umur'] = ($row['umur'] - $minVals[0]) / ($maxVals[0] - $minVals[0]);
            $normalizedRow['jenis_kelamin'] = ($row['jenis_kelamin'] - $minVals[1]) / ($maxVals[1] - $minVals[1]);
            $normalizedRow['kehamilan'] = ($row['kehamilan'] - $minVals[2]) / ($maxVals[2] - $minVals[2]);
            $normalizedRow['TSH'] = ($row['TSH'] - $minVals[3]) / ($maxVals[3] - $minVals[3]);
            $normalizedRow['T3'] = ($row['T3'] - $minVals[4]) / ($maxVals[4] - $minVals[4]);
            $normalizedRow['TT4'] = ($row['TT4'] - $minVals[5]) / ($maxVals[5] - $minVals[5]);
            $normalizedData[] = $normalizedRow;
        }
        $normalizedData = [
            $normalizedRow['umur'],
            $normalizedRow['jenis_kelamin'],
            $normalizedRow['kehamilan'],
            $normalizedRow['TSH'],
            $normalizedRow['T3'],
            $normalizedRow['TT4'],
        ];

        return $normalizedData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'umur' => 'required|numeric', 
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan', 
            'kehamilan' => 'required|in:Ya,Tidak', 
            'TSH' => 'required|numeric',
            'T3' => 'required|numeric',
            'TT4' => 'required|numeric',
        ]);

        $attributes =  $request->only(['umur', 'jenis_kelamin', 'kehamilan', 'TSH', 'T3', 'TT4']);
        $attributes['jenis_kelamin'] = $attributes['jenis_kelamin'] === 'Laki-Laki' ? 1 : 0;
        $attributes['kehamilan'] = $attributes['kehamilan'] === 'Ya' ? 1 : 0;

        $gejala = new Gejala([
            'umur' => $attributes['umur'],
            'jenis_kelamin' => $attributes['jenis_kelamin'],
            'kehamilan' => $attributes['kehamilan'],
            'TSH' => $attributes['TSH'],
            'T3' => $attributes['T3'],
            'TT4' => $attributes['TT4'],
        ]);

        $gejala->save();
        $out = 1;
        $hide = 7;
        $inputNeurons = 6;
        $neuralNetwork = new ANN(); 
        $filePath = storage_path('parameters.json');
        $neuralNetwork->loadParametersFromJson($filePath);

        if (count($attributes) == $inputNeurons) {

            $normalizedAttributes = $this->minMaxNormalization([$attributes]);
            $results = [];
            $result = $neuralNetwork->feedForwardTest($normalizedAttributes, $out, $hide, $filePath, $inputNeurons);
            $results[] = ['attributes' => $attributes, 'result' => $result];

            $diagnose = $result[0] >= 0.5 ? 'Anda Terkena penyakit hypertiroid' : 'Anda tidak terkena penyakit hypertiroid';
            $id_gejala = $gejala->id;
            $percentage = $result[0] * 100;
            $rounded_percentage = round($percentage);

            if ($rounded_percentage >= 50) {
                if ($attributes['TSH'] < 0.05 || $attributes['T3'] > 10 || $attributes['TT4'] > 220) {
                    $tingkat_penyakit = 4;
                } elseif ($attributes['TSH'] >= 0.05 && $attributes['TSH'] < 0.1 || $attributes['T3'] > 6 && $attributes['T3'] <= 10 || $attributes['TT4'] > 140 && $attributes['TT4'] <= 220) {
                    $tingkat_penyakit = 3;
                } elseif ($attributes['TSH'] >= 0.1 && $attributes['TSH'] <= 0.4 || $attributes['T3'] >= 4.2 && $attributes['T3'] <= 6 || $attributes['TT4'] >= 140 && $attributes['TT4'] <= 160) {
                    $tingkat_penyakit = 2;
                }elseif ($attributes['TSH'] > 0.05|| $attributes['T3'] < 4.2|| $attributes['TT4'] < 140) {
                    $tingkat_penyakit = 1;}
            } else {
                $tingkat_penyakit = 1;
            }

            $diagnosa = new Diagnosa([
                'id_gejala' => $id_gejala, 
                'id_level' => $tingkat_penyakit,
                'hasil_diagnosa' => $result[0],
                'presentase' => $rounded_percentage,
            ]);

            $diagnosa->save();
            alert()->info('diagnose', $diagnose);
            return back();
        }
        return redirect()->back()->with('error', 'Input pengguna harus terdiri dari 6 atribut.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Diagnosa  $diagnosa
     * @return \Illuminate\Http\Response
     */
    public function show(Diagnosa $diagnosa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Diagnosa  $diagnosa
     * @return \Illuminate\Http\Response
     */
    public function edit(Diagnosa $diagnosa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Diagnosa  $diagnosa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diagnosa $diagnosa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diagnosa  $diagnosa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diagnosa $diagnosa)
    {
        $diagnosa->delete();

        return redirect()->route('user.hasil')->with('success', 'Student Data deleted successfully');
    }
}
