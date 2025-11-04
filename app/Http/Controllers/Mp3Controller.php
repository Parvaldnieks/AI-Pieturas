<?php

namespace App\Http\Controllers;

use App\Models\Mp3;
use Illuminate\Http\Request;
use App\Models\Vesture; 

class Mp3Controller extends Controller
{
    public function index()
    {
        $mp3 = Vesture::whereNotNull('mp3_path')->orderByDesc('created_at')->get();

        return view('mp3.index', compact('mp3'));
    }
}
