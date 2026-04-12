<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarDokterController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.daftarDokter.index');
    }
}
