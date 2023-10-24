<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;

class UserIndexController extends Controller
{
    public function index(){
        $posts = Gejala::latest()->paginate(5); 
        return view('user.index', compact('posts'));
    }
}
