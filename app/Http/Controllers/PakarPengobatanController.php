<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengobatan;
use App\Models\Level;
use Illuminate\Support\Facades\DB;

class PakarPengobatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $level = Level::all();
        $drug = Pengobatan::with('level')->oldest()->paginate(5);
        return view('pakar.pengobatan', compact('drug','level'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'level'=>'required',
            'pengobatan' => 'required'
            ]);
            $drug = new Pengobatan;
            $drug->pengobatan = $request->pengobatan;
            $drug->level_penyakit = $request->level;
            $drug->save();
    
            return redirect()->route('index.pengobatan')->with('success', 'Pengobatan penyakit berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = Pengobatan::findOrFail($request->get('id'));

        echo json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = array(
            'pengobatan'=>$request->post('pengobatan'),
            'level_penyakit'=>$request->post('level')
            );
            $simpan = DB::table('table_pengobatan')->where('id','=',$request->post('id'))->update($data);
            if($simpan){
            return redirect()->route('index.pengobatan')->with('success','Data berhasil diupdate.');
            }else{
            return redirect()->route('index.pengobatan')->with('danger','Data gagal diupdate.');
            }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('table_pengobatan')->where('id', '=', $id)->delete();
        return redirect()->route('index.pengobatan')->with('success', 'data berhasil dihapus');
    }
}
