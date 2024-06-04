<?php

namespace App\Http\Controllers;

use App\Models\Jenis_ikan;
use Illuminate\Http\Request;

class jenisIkanController extends Controller
{
    public function index(){
        $dataIkan = Jenis_ikan::all();

        return view('Owner.batasOptimal', [
            'active' => "batas_optimal",
            'dataIkan' => $dataIkan
        ]);
    }
}
