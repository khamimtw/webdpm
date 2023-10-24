<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PakarLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $Level = Level::oldest()->paginate(5);
        return view('pakar.level', compact('Level'));
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
            'level_penyakit'=>'required',
            ]);
            $level = new level;
            $level->level_penyakit = $request->level_penyakit;
            $level->save();
    
            return redirect()->route('index.level')->with('success', 'Level penyakit berhasil disimpan');
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
        $data = Level::findOrFail($request->get('id'));

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
            'level_penyakit'=>$request->post('level_penyakit')
            );
            $simpan = DB::table('table_level')->where('id','=',$request->post('id'))->update($data);
            if($simpan){
                return redirect()->route('index.level')->with('success','Data berhasil diupdate.');
            }else{
                return redirect()->route('index.level')->with('danger','Data gagal diupdate.');
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
        DB::table('table_level')->where('id', '=', $id)->delete();
       return redirect()->route('index.level')->with('success', 'data berhasil dihapus');
    }
}
