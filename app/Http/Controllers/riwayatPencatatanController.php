<?php

namespace App\Http\Controllers;

use App\Models\pencatatan_pH;
use App\Models\pencatatan_suhu;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class riwayatPencatatanController extends Controller
{
    public function index(Request $request, ) {
        // Mengambil ID jenis ikan yang dipilih dari session atau menggunakan nilai default 1
        $selectedIkanId = $request->session()->get('selectedIkanId', 1);
    
        // Mengambil data riwayat suhu berdasarkan ID jenis ikan yang dipilih
        $history_suhu = DB::table('pencatatan_suhus')
            ->join('batas_optimal_suhus', 'batas_optimal_suhus.id', '=', 'pencatatan_suhus.Batas_optimal_suhu_ID')
            ->join('jenis_ikans', 'jenis_ikans.id', '=', 'batas_optimal_suhus.Jenis_ikan_ID')
            ->select('pencatatan_suhus.suhu_Kolam', 'pencatatan_suhus.Tanggal_Monitoring', 'jenis_ikans.Jenis_Ikan')
            ->where('jenis_ikans.id', '=', $selectedIkanId)
            ->get();
    
        // Mengambil data riwayat pH berdasarkan ID jenis ikan yang dipilih
        $history_ph = DB::table('pencatatan_p_h_s')
            ->join('batas_optimal_p_h_s', 'batas_optimal_p_h_s.id', '=', 'pencatatan_p_h_s.Batas_optimal_pH_ID')
            ->join('jenis_ikans', 'jenis_ikans.id', '=', 'batas_optimal_p_h_s.Jenis_ikan_ID')
            ->select('pencatatan_p_h_s.pH_Kolam', 'pencatatan_p_h_s.Tanggal_Monitoring', 'jenis_ikans.Jenis_Ikan')
            ->where('jenis_ikans.id', '=', $selectedIkanId)
            ->get();
    
        // Mengembalikan view dengan data yang diambil
        return view('Owner.riwayat_pecatatan', [
            'active' => 'riwayat_pencatatan',
            'history_suhu' => $history_suhu,
            'history_ph' => $history_ph,
        ]);
    }
    

    public function setSelectedIkanId(Request $request)
    {
        $selectedIkanId = $request->input('selectedIkanId');
        $request->session()->put('selectedIkanId', $selectedIkanId);
        return response()->json(['status' => 'success']);
    }
    
  //fungsi digunakan ketika ada jenis ikan yang dipilih
  public function get_data_by_jenis_ikan($id)
  {
      $history_suhu = DB::table('pencatatan_suhus')->join('batas_optimal_suhus', 'batas_optimal_suhus.id', '=', 'pencatatan_suhus.Batas_optimal_suhu_ID')->join('jenis_ikans', 'jenis_ikans.id', '=', 'batas_optimal_suhus.Jenis_ikan_ID')->select('pencatatan_suhus.suhu_Kolam', 'pencatatan_suhus.Tanggal_Monitoring', 'jenis_ikans.Jenis_Ikan')->where('jenis_ikans.id', '=', $id)->get();

      $history_ph = DB::table('pencatatan_p_h_s')->join('batas_optimal_p_h_s', 'batas_optimal_p_h_s.id', '=', 'pencatatan_p_h_s.Batas_optimal_pH_ID')->join('jenis_ikans', 'jenis_ikans.id', '=', 'batas_optimal_p_h_s.Jenis_ikan_ID')->select('pencatatan_p_h_s.pH_Kolam', 'pencatatan_p_h_s.Tanggal_Monitoring', 'jenis_ikans.Jenis_Ikan')->where('jenis_ikans.id', '=', $id)->get();

      return response()->json([
          'history_suhu' => $history_suhu,
          'history_ph' => $history_ph,
      ]);
  }

  public function filter(Request $request)
  {
      $tanggal_monitoring = $request->tanggal;
      $formatted_date = date('Y-m-d', strtotime($tanggal_monitoring));
      $history_suhu = pencatatan_suhu::whereDate('Tanggal_Monitoring', $formatted_date)->get();
      $history_ph = pencatatan_pH::whereDate('Tanggal_Monitoring', $formatted_date)->get();

      return view('Owner.riwayat_pecatatan', [
          'active' => 'riwayat_pencatatan',
          'history_suhu' => $history_suhu,
          'history_ph' => $history_ph,
      ]);
  }

  public function filterByDate(Request $request)
{
  $tanggal = $request->input('tanggal');
  $jenis_ikan_id = $request->input('jenis_ikan_id');

  $history_suhu = DB::table('pencatatan_suhus')
      ->join('batas_optimal_suhus', 'batas_optimal_suhus.id', '=', 'pencatatan_suhus.Batas_optimal_suhu_ID')
      ->join('jenis_ikans', 'jenis_ikans.id', '=', 'batas_optimal_suhus.Jenis_ikan_ID')
      ->select('pencatatan_suhus.suhu_Kolam', 'pencatatan_suhus.Tanggal_Monitoring', 'jenis_ikans.Jenis_Ikan')
      ->where('jenis_ikans.id', '=', $jenis_ikan_id)
      ->whereDate('pencatatan_suhus.Tanggal_Monitoring', $tanggal)
      ->get();

  $history_ph = DB::table('pencatatan_p_h_s')
      ->join('batas_optimal_p_h_s', 'batas_optimal_p_h_s.id', '=', 'pencatatan_p_h_s.Batas_optimal_pH_ID')
      ->join('jenis_ikans', 'jenis_ikans.id', '=', 'batas_optimal_p_h_s.Jenis_ikan_ID')
      ->select('pencatatan_p_h_s.pH_Kolam', 'pencatatan_p_h_s.Tanggal_Monitoring', 'jenis_ikans.Jenis_Ikan')
      ->where('jenis_ikans.id', '=', $jenis_ikan_id)
      ->whereDate('pencatatan_p_h_s.Tanggal_Monitoring', $tanggal)
      ->get();

  return response()->json([
      'history_suhu' => $history_suhu,
      'history_ph' => $history_ph,
  ]);
}

  public function cetak_history(Request $request)
  {
      // Data untuk tabel dari database (contoh)
      if($request->jenis === 'suhu'){
          $history_suhu = pencatatan_suhu::join('batas_optimal_suhus', 'batas_optimal_suhus.id', '=', 'Batas_optimal_suhu_ID')
          ->join('jenis_ikans', 'jenis_ikans.id', '=', 'batas_optimal_suhus.Jenis_ikan_ID')
          ->where('jenis_ikans.id','=',$request->jenis_ikan_id)
          ->get();
      }else{
          $history_suhu = pencatatan_pH::join('batas_optimal_p_h_s', 'batas_optimal_p_h_s.id', '=', 'Batas_optimal_pH_ID')
          ->join('jenis_ikans', 'jenis_ikans.id', '=', 'batas_optimal_p_h_s.Jenis_ikan_ID')
          ->where('jenis_ikans.id','=',$request->jenis_ikan_id)
          ->get();
      }
      $no = 1;

      if($request->jenis === 'suhu'){
           // Menghasilkan HTML untuk tabel
      $html = '
      <h2 style="text-align : center;">Laporan Pencatatan Suhu Kolam</h2>
      <table border="1" align="center" cellspacing="0" cellpadding="15" style="width: 90%;">
          <thead>
              <tr>
                  <th style="padding: 10px;">No.</th>
                  <th style="padding: 10px;">Tanggal</th>
                  <th style="padding: 10px;">Jam</th>
                  <th style="padding: 10px;">Suhu</th>
                  <th style="padding: 10px;">Jenis Ikan</th>
              </tr>
          </thead>
          <tbody>';
          // Isi tabel dengan data dari database
      foreach ($history_suhu as $suhu) {
          $html .=
              '
              <tr>
                  <td style="padding: 10px;">' .
              $no++ .
              '</td>
                  <td style="padding: 10px;">' .
              date('d-m-Y', strtotime($suhu->Tanggal_Monitoring)) .
              '</td>
                  <td style="padding: 10px;">' .
              date('H:i:s', strtotime($suhu->Tanggal_Monitoring)) .
              '</td>
                  <td style="padding: 10px;">' .
              $suhu->suhu_Kolam .
              ' &deg; C </td>
                  <td style="padding: 10px;">' .
              $suhu->Jenis_Ikan .
              ' </td>
              </tr>';
      }
      $html .= '
          </tbody>
      </table>';

      // Menghasilkan file PDF menggunakan mPDF
      $pdf = FacadePdf::loadHTML($html);
      return $pdf->download('history_pencatatan_suhu.pdf');
      }
      else{
           // Menghasilkan HTML untuk tabel
      $html = '
      <h2 style="text-align : center;">Laporan Pencatatan pH Kolam</h2>
      <table border="1" align="center" cellspacing="0" cellpadding="15" style="width: 90%;">
          <thead>
              <tr>
                  <th style="padding: 10px;">No.</th>
                  <th style="padding: 10px;">Tanggal</th>
                  <th style="padding: 10px;">Jam</th>
                  <th style="padding: 10px;">pH</th>
                  <th style="padding: 10px;">Jenis Ikan</th>
              </tr>
          </thead>
          <tbody>';
          // Isi tabel dengan data dari database
      foreach ($history_suhu as $suhu) {
          $html .=
              '
              <tr>
                  <td style="padding: 10px;">' .
              $no++ .
              '</td>
                  <td style="padding: 10px;">' .
              date('d-m-Y', strtotime($suhu->Tanggal_Monitoring)) .
              '</td>
                  <td style="padding: 10px;">' .
              date('H:i:s', strtotime($suhu->Tanggal_Monitoring)) .
              '</td>
                  <td style="padding: 10px;">' .
              $suhu->pH_Kolam .
              '</td>
                  <td style="padding: 10px;">' .
              $suhu->Jenis_Ikan .
              ' </td>
              </tr>';
      }
      $html .= '
          </tbody>
      </table>';

      // Menghasilkan file PDF menggunakan mPDF
      $pdf = FacadePdf::loadHTML($html);
      return $pdf->download('history_pencatatan_pH.pdf');
      }
  }
}
