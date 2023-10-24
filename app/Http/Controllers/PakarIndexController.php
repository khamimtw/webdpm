<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;

class PakarIndexController extends Controller
{
    public function index(){
        $post = Gejala::latest()->paginate(5); 
        return view('pakar.dashboard', compact('post'));
    }
}
