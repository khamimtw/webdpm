<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;

class AdminIndexController extends Controller
{
    public function index(){
        $post = Gejala::latest()->paginate(5); 
        return view('admin.index', compact('post'));
    }
}
