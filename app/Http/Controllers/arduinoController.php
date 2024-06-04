<?php

namespace App\Http\Controllers;

use App\Models\SetIdIkan;
use Illuminate\Http\Request;
use App\Models\pencatatan_pH;
use App\Models\pencatatan_suhu;
use App\Models\Batas_optimal_pH;
use App\Models\Batas_optimal_suhu;

class ArduinoController extends Controller
{
    private static $ikanId;

    public function storeData(Request $request, $ikanId) {
        SetIdIkan::insert([
            'id' => $ikanId,
            'created_at' => now(),
        ]);

        return response()->json(['message' => 'idIkan berhasil disimpan'], 200)->with('berhasil_kirim', '');
    }


    public function store(Request $request) {
        $data = $request->all();
        
        $setIdIkan = SetIdIkan::latest()->first();
        
        if ($setIdIkan) {
            $ikanId = $setIdIkan->id;
            pencatatan_pH::insert([
                'pH_Kolam' => $data['pH'],
                'batas_optimal_pH_id' => $ikanId,
                'Tanggal_Monitoring' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            pencatatan_suhu::insert([
                'suhu_Kolam' => $data['suhu'],
                'batas_optimal_suhu_id' => $ikanId,
                'Tanggal_Monitoring' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['error' => 'Data tidak lengkap'], 400);
        }
    }
    
    public function checkOptimalConditions() {
        // Ambil ID jenis ikan terbaru dari tabel set_id_ikan
        $setIdIkan = SetIdIkan::latest()->first();
        $ikanId = $setIdIkan->id;
    
        // Cari batas optimal pH dan suhu berdasarkan jenis ikan
        $batasOptimalPH = Batas_optimal_pH::where('Jenis_ikan_ID', $ikanId)->first();
        $batasOptimalSuhu = Batas_optimal_suhu::where('Jenis_ikan_ID', $ikanId)->first();
    
        // Ambil data pencatatan pH dan suhu terakhir
        $latestPH = pencatatan_pH::where('batas_optimal_pH_id', $ikanId)->orderBy('Tanggal_Monitoring', 'desc')->first();
        $latestSuhu = pencatatan_suhu::where('batas_optimal_suhu_id', $ikanId)->orderBy('Tanggal_Monitoring', 'desc')->first();
    
        // Inisialisasi respons
        $response = [
            'pH_status' => 0,
            'suhu_status' => 0
        ];
    
        // Periksa kondisi optimal pH
        if ($latestPH) {
            if ($latestPH->pH_Kolam > $batasOptimalPH->pH_Maximal || $latestPH->pH_Kolam < $batasOptimalPH->pH_Minimal) {
                $response['pH_status'] = 1;
            } else {
                $response['pH_status'] = 0;
            }
        }
        
        // Periksa kondisi optimal suhu
        if ($latestSuhu) {
            if ($latestSuhu->suhu_Kolam > $batasOptimalSuhu->Suhu_Maximal || $latestSuhu->suhu_Kolam < $batasOptimalSuhu->Suhu_Minimal) {
                $response['suhu_status'] = 1;
            } else {
                $response['suhu_status'] = 0;
            }
        }
    
        // Kembalikan respons dalam format JSON
        return response()->json($response, 200);
    }
}    
