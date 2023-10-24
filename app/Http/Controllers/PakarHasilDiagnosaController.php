<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use Illuminate\Http\Request;
use App\Models\ANN;
use App\Models\Gejala;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class PakarHasilDiagnosaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hasil()
    {
        $diagnosa = Diagnosa::latest()
    ->join('table_gejala', 'table_diagnosa.id_gejala', '=', 'id')
    ->select('table_diagnosa.*', 'table_gejala.umur', 'table_gejala.jenis_kelamin', 'table_gejala.kehamilan', 'table_gejala.TSH', 'table_gejala.T3', 'table_gejala.TT4')->get();
        return view('pakar.riwayat', compact('diagnosa'));
    }
    public function destroy($id)
    {
        DB::table('table_diagnosa')->where('id_diagnosa', '=', $id)->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}