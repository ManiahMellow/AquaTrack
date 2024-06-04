<?php

namespace App\Http\Controllers;

use App\Models\pencatatan_pH;
use App\Models\pencatatan_suhu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class berandaController extends Controller
{
    public function index(Request $request){
        $ikan_id = 1;

        $now_suhu = pencatatan_suhu::latest()->first();
        $now_ph = pencatatan_pH::latest()->first();
        
        $suhu = DB::table('pencatatan_suhus')
            ->join('batas_optimal_suhus', 'batas_optimal_suhus.id','=', 'pencatatan_suhus.Batas_optimal_suhu_ID')
            ->join('jenis_ikans','jenis_ikans.id', '=', 'batas_optimal_suhus.Jenis_ikan_ID')
            ->select('batas_optimal_suhus.Suhu_Minimal','batas_optimal_suhus.Suhu_Maximal', 'pencatatan_suhus.suhu_Kolam' )
            ->where('jenis_ikans.id', '=', $ikan_id)
            ->first();

        $pH = DB::table('pencatatan_p_h_s')
            ->join('batas_optimal_p_h_s', 'batas_optimal_p_h_s.id','=', 'pencatatan_p_h_s.Batas_optimal_pH_ID')
            ->join('jenis_ikans','jenis_ikans.id', '=', 'batas_optimal_p_h_s.Jenis_ikan_ID')
            ->select('batas_optimal_p_h_s.pH_Minimal','batas_optimal_p_h_s.pH_Maximal', 'pencatatan_p_h_s.pH_Kolam' )
            ->where('jenis_ikans.id', '=', $ikan_id)
            ->first();

        $optimal_suhu = ($suhu->suhu_Kolam >= $suhu->Suhu_Minimal && $suhu->suhu_Kolam <= $suhu->Suhu_Maximal) ? "optimal" : "Tidak Optimal" ;
        $optimal_pH = ($pH->pH_Kolam >= $pH->pH_Minimal && $pH->pH_Kolam <= $pH->pH_Maximal) ? "optimal" : "Tidak Optimal" ;

        return view('Owner.beranda', [
            'active' => "beranda",
            'now_suhu'  =>  $now_suhu,
            'now_ph'  =>  $now_ph,
            'optimal_suhu'    => $optimal_suhu,
            'optimal_pH'    => $optimal_pH,
        ]);
    }
}
