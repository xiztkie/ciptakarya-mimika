<?php

namespace App\Http\Controllers;

use App\Models\SyncdataModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    public function index(Request $request)
    {
        $data =  [
            'title' => 'Sync Data',
            'active' => 'sync-data',
            'syncdata' => SyncdataModel::all(),
        ];

        return view('admin.sync-data', $data);
    }

    public function syncpenyedia(Request $request)
    {
        set_time_limit(300);
        $tahun = $request->tahun;
        $klpd = config('services.lkpp.kode_klpd');
        $totalSynced = 0;

        try {
            $response = Http::get(config('services.lkpp.isb_sirup_penyedia_terumumkan') . $tahun . ':' . $klpd);
            $data = $response->json();
            if (!is_array($data)) {
                Log::error('Data paket penyedia tidak valid. Response: ' . $response->body());
                return redirect()->back()->with('error', 'Data paket penyedia tidak valid atau kosong.');
            }

            foreach ($data as $item) {
                PaketModel::updateOrCreate(
                    ['kd_rup' => $item['kd_rup']],
                    [
                        'tahun_anggaran' => $item['tahun_anggaran'],
                        'nama_paket' => $item['nama_paket'],
                        'pagu' => $item['pagu'],
                        'tipe_paket' => $item['tipe_paket'],
                        'metode_pengadaan' => $item['metode_pengadaan'],
                        'jenis_pengadaan' => $item['jenis_pengadaan'],
                    ]
                );
                $totalSynced++;
            }
            $response1 = Http::get(config('services.lkpp.isb_sirup_anggaran_penyedia') . $tahun . ':' . $klpd);
            $data1 = $response1->json();

            if (!is_array($data1)) {
                Log::error('Data anggaran tidak valid. Response: ' . $response1->body());
                return redirect()->back()->with('error', 'Data anggaran tidak valid atau kosong.');
            }

            foreach ($data1 as $item1) {
                DpapaketModel::updateOrCreate(
                    ['kd_rup' => $item1['kd_rup']],
                    [
                        'mak' => $item1['mak'],
                        'kd_subkegiatan_str' => substr($item1['mak'] ?? '', 0, 17),
                        'sumber_dana' => $item1['sumber_dana'],
                    ]
                );
                $totalSynced++;
            }

            $response2 = Http::get(config('services.lkpp.isb_sirup_penyedia_lokasi') . $tahun . ':' . $klpd);
            $data2 = $response2->json();

            if (!is_array($data2)) {
                Log::error('Data lokasi tidak valid. Response: ' . $response2->body());
                return redirect()->back()->with('error', 'Data lokasi tidak valid atau kosong.');
            }

            foreach ($data2 as $item2) {
                $paket = DpapaketModel::where('kd_rup', $item2['kd_rup'])->first();
                if (!$paket) {
                    continue;
                }

                $paket->update([
                    'detail_lokasi' => $item2['detail_lokasi']
                ]);

                $totalSynced++;
            }

            $totalData = DpapaketModel::whereNotNull('tipe_paket')->count();
            SyncdataModel::findOrFail($id)->touch();

            return redirect()->back()->with([
                'success' => "Sinkronisasi berhasil! Total {$totalSynced} entri diproses.",
                'totalData' => $totalData
            ]);
        } catch (\Exception $e) {
            Log::error('Sinkronisasi Paket Penyedia Gagal: ' . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'Terjadi kesalahan saat sinkronisasi: ' . $e->getMessage()
            );
        }
    }

    public function synckontraktender(Request $request)
    {
        $id = $request->id;
        $tahun = session('tahun_anggaran_aktif');
        $lpse = config('services.lkpp.kode_lpse');
        $totalSynced = 0;

        try {
            $response = Http::get(config('services.lkpp.isb_spse_tender_pengumuman') . $tahun . ':' . $lpse);
            $data = $response->json();
            if (!is_array($data)) {
                Log::error('Data paket tender tidak valid. Response: ' . $response->body());
                return redirect()->back()->with('error', 'Data paket tender tidak valid atau kosong.');
            }

            foreach ($data as $item) {
                KontrakModel::updateOrCreate(
                    ['kd_rup' => $item['kd_rup']],
                    [
                        'kd_tender' => $item['kd_tender'],
                    ]
                );
                $totalSynced++;
            }
            $response1 = Http::get(config('services.lkpp.isb_spse_tender_kontrak') . $tahun . ':' . $lpse);
            $data1 = $response1->json();

            if (!is_array($data1)) {
                Log::error('Data tender tidak valid. Response: ' . $response1->body());
                return redirect()->back()->with('error', 'Data tender tidak valid atau kosong.');
            }



            foreach ($data1 as $item1) {
                $raw = $item1['tgl_kontrak'] ?? null;
                $tgl = $raw ? Carbon::parse($raw)->tz('Asia/Jayapura')->toDateString() : null;

                KontrakModel::updateOrCreate(
                    ['kd_tender' => $item1['kd_tender']],
                    [
                        'no_kontrak'   => $item1['no_kontrak'],
                        'tgl_kontrak'  => $tgl,
                        'nilai_kontrak' => $item1['nilai_kontrak'],
                        'nama_penyedia' => $item1['nama_penyedia'],
                        'npwp_penyedia' => $item1['npwp_penyedia'],
                        'wakil_sah_penyedia' => $item1['wakil_sah_penyedia'],
                    ]
                );

                $totalSynced++;
            }


            $response2 = Http::get(config('services.lkpp.isb_spse_tender_spmk') . $tahun . ':' . $lpse);
            $data2 = $response2->json();

            if (!is_array($data2)) {
                Log::error('Data lokasi tidak valid. Response: ' . $response2->body());
                return redirect()->back()->with('error', 'Data lokasi tidak valid atau kosong.');
            }

            foreach ($data2 as $item2) {
                $paket = KontrakModel::where('kd_tender', $item2['kd_tender'])->first();
                if (!$paket) {
                    continue;
                }

                $paket->update([
                    'waktu_pelaksanaan' => $item2['waktu_penyelesaian']
                ]);

                $totalSynced++;
            }

            $totalData = DpapaketModel::whereNotNull('tipe_swakelola')->count();
            SyncdataModel::findOrFail($id)->touch();

            return redirect()->back()->with([
                'success' => "Sinkronisasi berhasil! Total {$totalSynced} entri diproses.",
                'totalData' => $totalData
            ]);
        } catch (\Exception $e) {
            Log::error('Sinkronisasi Paket Penyedia Gagal: ' . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'Terjadi kesalahan saat sinkronisasi: ' . $e->getMessage()
            );
        }
    }

    public function synckontraknontender(Request $request)
    {
        $id = $request->id;
        $tahun = session('tahun_anggaran_aktif');
        $lpse = config('services.lkpp.kode_lpse');
        $totalSynced = 0;

        try {
            $response = Http::get(config('services.lkpp.isb_spse_nontender_pengumuman') . $tahun . ':' . $lpse);
            $data = $response->json();
            if (!is_array($data)) {
                Log::error('Data paket nontender tidak valid. Response: ' . $response->body());
                return redirect()->back()->with('error', 'Data paket nontender tidak valid atau kosong.');
            }

            foreach ($data as $item) {
                KontrakModel::updateOrCreate(

                    ['kd_nontender' => $item['kd_nontender']],
                    ['kd_rup' => $item['kd_rup']]
                );
                $totalSynced++;
            }

            $response1 = Http::get(config('services.lkpp.isb_spse_nontender_kontrak') . $tahun . ':' . $lpse);
            $data1 = $response1->json();

            if (!is_array($data1)) {
                Log::error('Data kontrak nontender tidak valid. Response: ' . $response1->body());
                return redirect()->back()->with('error', 'Data kontrak nontender tidak valid atau kosong.');
            }

            foreach ($data1 as $item1) {
                $raw = $item1['tgl_kontrak'] ?? null;
                $tgl = $raw ? Carbon::parse($raw)->tz('Asia/Jayapura')->toDateString() : null;

                KontrakModel::updateOrCreate(
                    ['kd_nontender' => $item1['kd_nontender']],
                    [
                        'no_kontrak'   => $item1['no_kontrak'],
                        'tgl_kontrak'  => $tgl,
                        'nilai_kontrak' => $item1['nilai_kontrak'],
                        'nama_penyedia' => $item1['nama_penyedia'],
                        'npwp_penyedia' => $item1['npwp_penyedia'],
                        'wakil_sah_penyedia' => $item1['wakil_sah_penyedia'],
                    ]
                );

                $totalSynced++;
            }

            $response2 = Http::get(config('services.lkpp.isb_spse_nontender_spmk') . $tahun . ':' . $lpse);
            $data2 = $response2->json();

            if (!is_array($data2)) {
                Log::error('Data SPMK nontender tidak valid. Response: ' . $response2->body());
                return redirect()->back()->with('error', 'Data SPMK nontender tidak valid atau kosong.');
            }

            foreach ($data2 as $item2) {
                $paket = KontrakModel::where('kd_nontender', $item2['kd_nontender'])->first();
                if (!$paket) {
                    continue;
                }

                $paket->update([
                    'waktu_pelaksanaan' => $item2['waktu_penyelesaian']
                ]);

                $totalSynced++;
            }

            $totalData = KontrakModel::whereNotNull('kd_nontender')->count();
            SyncdataModel::findOrFail($id)->touch();

            return redirect()->back()->with([
                'success' => "Sinkronisasi berhasil! Total {$totalSynced} entri diproses.",
                'totalData' => $totalData
            ]);
        } catch (\Exception $e) {
            Log::error('Sinkronisasi Paket Nontender Gagal: ' . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'Terjadi kesalahan saat sinkronisasi: ' . $e->getMessage()
            );
        }
    }
}
