<?php

namespace App\Http\Controllers;

use App\Models\Batas_optimal_pH;
use App\Models\Batas_optimal_suhu;
use App\Models\Jenis_ikan;
use App\Models\pencatatan_pH;
use App\Models\pencatatan_suhu;
use Dotenv\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class batasOptimalController extends Controller
{
    public function index()
    {
        $bataOptimalSuhu = Batas_optimal_suhu::all();
        $dataIkan = Jenis_ikan::all();
        return view('Owner.batasOptimal', [
            'active' => 'batas_optimal',
            'dataIkan' => $dataIkan,
            'batasOptimalSuhu' => $bataOptimalSuhu,
        ]);
    }

    //fungsi ini digunakan ketika ada jenis ikan yang dipilih dihalaman view batas optimal
    public function getDataBatasOptimal($id)
    {
        // Logika untuk mengambil data ikan berdasarkan ID
        $suhu = Batas_optimal_suhu::where('Jenis_ikan_ID', $id)->first();
        $ph = Batas_optimal_pH::where('Jenis_ikan_ID', $id)->first();
        $now_suhu = pencatatan_suhu::where('Batas_optimal_suhu_ID', $suhu->id)->get()->last();
        $now_ph = pencatatan_pH::where('Batas_optimal_pH_ID', $ph->id)->get()->last();
        
        // Periksa apakah suhu kolam optimal atau tidak
        $optimal_suhu = ($now_suhu->suhu_Kolam >= $suhu->Suhu_Minimal && $now_suhu->suhu_Kolam <= $suhu->Suhu_Maximal) ? "optimal" : "Tidak Optimal";
    
        // Periksa apakah pH kolam optimal atau tidak
        $optimal_pH = ($now_ph->pH_Kolam >= $ph->pH_Minimal && $now_ph->pH_Kolam <= $ph->pH_Maximal) ? "optimal" : "Tidak Optimal";
    
        // Mengembalikan data dalam format JSON
        return response()->json([
            'minimal_suhu' => $suhu->Suhu_Minimal,
            'maksimal_suhu' => $suhu->Suhu_Maximal,
            'minimal_pH' => $ph->pH_Minimal,
            'maksimal_pH' => $ph->pH_Maximal,
            'now_suhu' => $now_suhu->suhu_Kolam,
            'now_ph' => $now_ph->pH_Kolam,
            'optimal_suhu' => $optimal_suhu,
            'optimal_ph' => $optimal_pH,
        ]);
    }
    

    public function update_batas_ph(Request $request, $id){
        if(empty($request->minimal_ph) || empty($request->maksimal_ph) ){
            return back()->with('nilai_kosong','');
        }
        if(!is_numeric($request->minimal_ph) || !is_numeric($request->maksimal_ph)){
            return back()->with('nilai_bukan_angka','');
        }
        
        if($request->minimal_ph > $request->maksimal_ph){
            return back()->with('batas_lebih','');
        }

        $optimal_ph = Batas_optimal_pH::where('Jenis_ikan_ID', '=', $id)->get()->first();
        $optimal_ph->update([
            'pH_Minimal' => $request->minimal_ph,
            'pH_Maximal' => $request->maksimal_ph
        ]);

        return redirect()->back()->with('success_ubah_ph', '');

    }

    public function update_batas_suhu(Request $request, $id){
        if(empty($request->minimal_suhu) || empty($request->maksimal_suhu) ){
            return back()->with('nilai_kosong','');
        }
        if(!is_numeric($request->minimal_suhu) || !is_numeric($request->maksimal_suhu)){
            return back()->with('nilai_bukan_angka','');
        }

        if($request->minimal_suhu > $request->maksimal_suhu){
            return back()->with('batas_lebih','');
        }

        $optimal_ph = Batas_optimal_suhu::where('Jenis_ikan_ID', '=', $id)->get()->first();
        $optimal_ph->update([
            'Suhu_Minimal' => $request->minimal_suhu,
            'Suhu_Maximal' => $request->maksimal_suhu
        ]);

        return redirect()->back()->with('success_ubah_suhu', '');
    }
}
