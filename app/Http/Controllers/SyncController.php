<?php

namespace App\Http\Controllers;

use App\Models\KontrakModel;
use App\Models\PaketModel;
use App\Models\PenyediaModel;
use App\Models\SyncdataModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;

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
        set_time_limit(600);

        $validated = $request->validate([
            'tahun' => ['required', 'digits:4'],
            'id'    => ['required', 'integer', 'exists:syncdata,id'],
        ]);

        $tahun = $validated['tahun'];
        $klpd  = config('services.lkpp.kode_klpd');
        $id    = (int) $validated['id'];
        $now   = now();

        if (method_exists(DB::getFacadeRoot(), 'disableQueryLog')) {
            DB::disableQueryLog();
        }

        try {
            $base = rtrim(config('services.lkpp.isb_sirup_penyedia_terumumkan'));
            $url  = "{$base}{$tahun}:{$klpd}";

            $response = Http::timeout(60)
                ->retry(3, 200)
                ->acceptJson()
                ->get($url);

            if (!$response->ok()) {
                Log::error("Gagal mengakses API LKPP. URL: {$url}, Status: {$response->status()}, Body: " . $response->body());
                return back()->with('error', "Tidak dapat mengakses API LKPP (status {$response->status()}). Silakan coba lagi nanti.");
            }

            $data = $response->json();

            if (!is_array($data) || empty($data)) {
                Log::error('Data paket penyedia tidak valid atau kosong. Response: ' . $response->body());
                return back()->with('error', 'Data paket penyedia tidak valid atau kosong.');
            }

            $rows = [];
            foreach ($data as $item) {
                if (empty($item['kd_rup'])) {
                    continue;
                }
                // Filter hanya nip_ppk = 197703222008011014
                if (($item['nip_ppk'] ?? null) !== '197703222008011014') {
                    continue;
                }

                $rows[] = [
                    'kd_rup'            => $item['kd_rup'],
                    'kd_satker_str'    => $item['kd_satker_str'] ?? null,
                    'nama_satker'      => $item['nama_satker'] ?? null,
                    'tahun_anggaran'    => $item['tahun_anggaran'] ?? $tahun,
                    'nama_paket'        => $item['nama_paket'] ?? null,
                    'pagu'              => $item['pagu'] ?? null,
                    'metode_pengadaan'  => $item['metode_pengadaan'] ?? null,
                    'jenis_pengadaan'   => $item['jenis_pengadaan'] ?? null,
                    'nama_ppk'          => $item['nama_ppk'] ?? null,
                    'nip_ppk'           => $item['nip_ppk'] ?? null,
                    'bidang'            => 'Bidang Cipta Karya',
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ];
            }

            if (empty($rows)) {
                Log::warning('Tidak ada item dengan kd_rup dan nip_ppk=197703222008011014 pada respon API.');
                SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);

                return back()->with([
                    'success'    => 'Sinkronisasi selesai, namun tidak ada data valid untuk diproses.',
                    'totalData'  => PaketModel::where('tahun_anggaran', $tahun)->where('nip_ppk', '197703222008011014')->count(),
                    'tahun'      => $tahun,
                ]);
            }

            $batchSize    = 1000;
            $totalSynced  = 0;

            foreach (array_chunk($rows, $batchSize) as $chunk) {
                PaketModel::upsert(
                    $chunk,
                    ['kd_rup'],
                    [
                        'kd_satker_str',
                        'nama_satker',
                        'tahun_anggaran',
                        'nama_paket',
                        'pagu',
                        'metode_pengadaan',
                        'jenis_pengadaan',
                        'nama_ppk',
                        'nip_ppk',
                        'updated_at',
                    ]
                );

                $totalSynced += count($chunk);
            }

            $totalData = PaketModel::where('tahun_anggaran', $tahun)->where('nip_ppk', '197703222008011014')->count();

            SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);

            return back()->with([
                'success'    => "Sinkronisasi berhasil! Total {$totalSynced} entri diproses.",
                'totalData'  => $totalData,
                'tahun'      => $tahun,
            ]);
        } catch (ConnectionException $e) {
            Log::error('Tidak dapat menghubungi API LKPP: ' . $e->getMessage());
            return back()->with('error', 'Link API tidak bisa diakses. Periksa koneksi jaringan atau URL API, lalu coba lagi.');
        } catch (\Throwable $e) {
            Log::error('Sinkronisasi Paket Penyedia Gagal: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat sinkronisasi: ' . $e->getMessage());
        }
    }

    public function synclokasipenyedia(Request $request)
    {
        set_time_limit(600);

        $validated = $request->validate([
            'tahun' => ['required', 'digits:4'],
            'id'    => ['required', 'integer', 'exists:syncdata,id'],
        ]);

        $tahun = $validated['tahun'];
        $klpd  = config('services.lkpp.kode_klpd');
        $id    = (int) $validated['id'];
        $now   = now();

        if (method_exists(DB::getFacadeRoot(), 'disableQueryLog')) {
            DB::disableQueryLog();
        }

        try {
            $base = rtrim(config('services.lkpp.isb_sirup_penyedia_lokasi', config('services.lkpp.isb_sirup_penyedia_terumumkan')));
            $url  = "{$base}{$tahun}:{$klpd}";

            $response = Http::timeout(60)
                ->retry(3, 200)
                ->acceptJson()
                ->get($url);

            if (!$response->ok()) {
                Log::error("Gagal mengakses API LKPP (lokasi). URL: {$url}, Status: {$response->status()}, Body: " . $response->body());
                return back()->with('error', "Tidak dapat mengakses API LKPP (status {$response->status()}). Silakan coba lagi nanti.");
            }

            $data = $response->json();

            if (!is_array($data) || empty($data)) {
                Log::error('Data lokasi penyedia tidak valid atau kosong. Response: ' . $response->body());
                return back()->with('error', 'Data lokasi penyedia tidak valid atau kosong.');
            }

            // Ambil kd_rup yang ada di PaketModel untuk tahun ini
            $paketRups = PaketModel::where('tahun_anggaran', $tahun)
                ->pluck('kd_rup')
                ->filter()
                ->unique()
                ->toArray();

            $mapLokasi = [];
            foreach ($data as $item) {
                if (empty($item['kd_rup']) || !in_array($item['kd_rup'], $paketRups)) {
                    continue;
                }
                if (!array_key_exists('detail_lokasi', $item) || $item['detail_lokasi'] === null) {
                    continue;
                }
                $mapLokasi[$item['kd_rup']] = $item['detail_lokasi'];
            }

            if (empty($mapLokasi)) {
                Log::warning('Tidak ada item lokasi valid (kd_rup + detail_lokasi) pada respon API yang cocok dengan PaketModel.');
                SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);

                return back()->with([
                    'success'    => 'Sinkronisasi lokasi selesai, namun tidak ada data valid untuk diperbarui.',
                    'tahun'      => $tahun,
                    'totalData'  => PaketModel::where('tahun_anggaran', $tahun)->count(),
                ]);
            }

            $rowsToUpdate = [];
            foreach ($mapLokasi as $rup => $lokasi) {
                $rowsToUpdate[] = [
                    'kd_rup'        => $rup,
                    'tahun_anggaran' => $tahun,
                    'detail_lokasi' => $lokasi,
                    'updated_at'    => $now,
                ];
            }

            if (empty($rowsToUpdate)) {
                SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);
                return back()->with([
                    'success'   => 'Tidak ada data yang cocok untuk diperbarui.',
                    'tahun'     => $tahun,
                    'totalData' => PaketModel::where('tahun_anggaran', $tahun)->whereNotNull('detail_lokasi')->count(),
                ]);
            }

            foreach (array_chunk($rowsToUpdate, 1000) as $chunk) {
                PaketModel::upsert(
                    $chunk,
                    ['kd_rup', 'tahun_anggaran'],
                    ['detail_lokasi', 'updated_at']
                );
            }

            $updatedCount = count($rowsToUpdate);
            $totalData    = PaketModel::where('tahun_anggaran', $tahun)->count();

            SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);

            return back()->with([
                'success'    => "Sinkronisasi lokasi berhasil! {$updatedCount} entri diperbarui.",
                'tahun'      => $tahun,
                'totalData'  => $totalData,
            ]);
        } catch (ConnectionException $e) {
            Log::error('Tidak dapat menghubungi API LKPP (lokasi): ' . $e->getMessage());
            return back()->with('error', 'Link API tidak bisa diakses. Periksa koneksi jaringan atau URL API, lalu coba lagi.');
        } catch (\Throwable $e) {
            Log::error('Sinkronisasi Lokasi Penyedia Gagal: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat sinkronisasi lokasi: ' . $e->getMessage());
        }
    }

    public function synctender(Request $request)
    {
        set_time_limit(600);

        $validated = $request->validate([
            'tahun' => ['required', 'digits:4'],
            'id'    => ['required', 'integer', 'exists:syncdata,id'],
        ]);

        $tahun = $validated['tahun'];
        $lpse = config('services.lkpp.kode_lpse');
        $id    = (int) $validated['id'];
        $now   = now();

        if (method_exists(DB::getFacadeRoot(), 'disableQueryLog')) {
            DB::disableQueryLog();
        }

        try {
            $base = rtrim(config('services.lkpp.isb_spse_tender_pengumuman'));
            $url  = "{$base}{$tahun}:{$lpse}";

            $response = Http::timeout(60)
                ->retry(3, 200)
                ->acceptJson()
                ->get($url);

            if (!$response->ok()) {
                Log::error("Gagal mengakses API LKPP (tender). URL: {$url}, Status: {$response->status()}, Body: " . $response->body());
                return back()->with('error', "Tidak dapat mengakses API LKPP (status {$response->status()}). Silakan coba lagi nanti.");
            }

            $data = $response->json();

            if (!is_array($data) || empty($data)) {
                Log::error('Data tender penyedia tidak valid atau kosong. Response: ' . $response->body());
                return back()->with('error', 'Data tender penyedia tidak valid atau kosong.');
            }

            // Ambil kd_rup dari PaketModel untuk tahun ini
            $paketRups = PaketModel::where('tahun_anggaran', $tahun)
                ->pluck('kd_rup')
                ->filter()
                ->unique()
                ->toArray();

            $incomingByRup = [];
            foreach ($data as $item) {
                if (empty($item['kd_rup']) || !in_array($item['kd_rup'], $paketRups)) {
                    continue;
                }

                $payload = [];
                if (array_key_exists('kd_tender', $item) && $item['kd_tender'] !== null) {
                    $payload['kd_tender'] = $item['kd_tender'];
                }
                if (array_key_exists('status_tender', $item) && $item['status_tender'] !== null) {
                    $payload['status_tender'] = $item['status_tender'];
                }
                if (array_key_exists('hps', $item) && $item['hps'] !== null) {
                    $payload['hps'] = $item['hps'];
                }

                if (!empty($payload)) {
                    $incomingByRup[$item['kd_rup']] = $payload;
                }
            }

            if (empty($incomingByRup)) {
                Log::warning('Tidak ada item tender valid (kd_rup + salah satu dari kd_tender/status_tender/hps) pada respon API yang cocok dengan PaketModel.');
                SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);

                return back()->with([
                    'success'    => 'Sinkronisasi tender selesai, namun tidak ada data valid untuk diperbarui.',
                    'tahun'      => $tahun,
                    'totalData'  => PaketModel::where('tahun_anggaran', $tahun)->count(),
                ]);
            }

            $batchSize     = 1000;
            $allRups       = array_keys($incomingByRup);
            $totalUpdated  = 0;

            foreach (array_chunk($allRups, $batchSize) as $rupChunk) {
                $existingRows = PaketModel::query()
                    ->select(['kd_rup', 'kd_tender', 'status_tender', 'hps'])
                    ->where('tahun_anggaran', $tahun)
                    ->whereIn('kd_rup', $rupChunk)
                    ->get()
                    ->keyBy('kd_rup');

                if ($existingRows->isEmpty()) {
                    continue;
                }

                foreach ($existingRows as $rup => $row) {
                    $payload = $incomingByRup[$rup] ?? null;
                    if (!$payload) {
                        continue;
                    }

                    $updateData = [
                        'updated_at' => $now,
                    ];

                    $updateData['kd_tender'] = array_key_exists('kd_tender', $payload) ? $payload['kd_tender'] : $row->kd_tender;
                    $updateData['status_tender'] = array_key_exists('status_tender', $payload) ? $payload['status_tender'] : $row->status_tender;
                    $updateData['hps'] = array_key_exists('hps', $payload) ? $payload['hps'] : $row->hps;

                    $affected = PaketModel::where('tahun_anggaran', $tahun)
                        ->where('kd_rup', $rup)
                        ->update($updateData);

                    $totalUpdated += $affected;
                }
            }

            SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);

            $totalData = PaketModel::where('tahun_anggaran', $tahun)->count();

            return back()->with([
                'success'    => "Sinkronisasi tender berhasil! {$totalUpdated} entri diperbarui.",
                'tahun'      => $tahun,
                'totalData'  => $totalData,
            ]);
        } catch (ConnectionException $e) {
            Log::error('Tidak dapat menghubungi API LKPP (tender): ' . $e->getMessage());
            return back()->with('error', 'Link API tidak bisa diakses. Periksa koneksi jaringan atau URL API, lalu coba lagi.');
        } catch (\Throwable $e) {
            Log::error('Sinkronisasi Tender Penyedia Gagal: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat sinkronisasi tender: ' . $e->getMessage());
        }
    }

    public function syncnontender(Request $request)
    {
        set_time_limit(600);

        $validated = $request->validate([
            'tahun' => ['required', 'digits:4'],
            'id'    => ['required', 'integer', 'exists:syncdata,id'],
        ]);

        $tahun = $validated['tahun'];
        $lpse  = config('services.lkpp.kode_lpse');
        $id    = (int) $validated['id'];
        $now   = now();

        if (method_exists(DB::getFacadeRoot(), 'disableQueryLog')) {
            DB::disableQueryLog();
        }

        try {
            $base = rtrim(config('services.lkpp.isb_spse_nontender_pengumuman'));
            $url  = "{$base}{$tahun}:{$lpse}";

            $response = Http::timeout(60)
                ->retry(3, 200)
                ->acceptJson()
                ->get($url);

            if (!$response->ok()) {
                Log::error("Gagal mengakses API LKPP (nontender). URL: {$url}, Status: {$response->status()}, Body: " . $response->body());
                return back()->with('error', "Tidak dapat mengakses API LKPP (status {$response->status()}). Silakan coba lagi nanti.");
            }

            $data = $response->json();

            if (!is_array($data) || empty($data)) {
                Log::error('Data nontender tidak valid atau kosong. Response: ' . $response->body());
                return back()->with('error', 'Data nontender tidak valid atau kosong.');
            }

            // Ambil kd_rup dari PaketModel untuk tahun ini
            $paketRups = PaketModel::where('tahun_anggaran', $tahun)
                ->pluck('kd_rup')
                ->filter()
                ->unique()
                ->toArray();

            $incomingByRup = [];
            foreach ($data as $item) {
                if (empty($item['kd_rup']) || !in_array($item['kd_rup'], $paketRups)) {
                    continue;
                }

                $payload = [];
                if (array_key_exists('kd_nontender', $item) && $item['kd_nontender'] !== null) {
                    $payload['kd_nontender'] = $item['kd_nontender'];
                }
                if (array_key_exists('status_nontender', $item) && $item['status_nontender'] !== null) {
                    $payload['status_nontender'] = $item['status_nontender'];
                }
                if (array_key_exists('hps', $item) && $item['hps'] !== null) {
                    $payload['hps'] = $item['hps'];
                }

                if (!empty($payload)) {
                    $incomingByRup[$item['kd_rup']] = $payload;
                }
            }

            if (empty($incomingByRup)) {
                Log::warning('Tidak ada item nontender valid (kd_rup + salah satu dari kd_nontender/status_nontender/hps) pada respon API yang cocok dengan PaketModel.');
                SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);

                return back()->with([
                    'success'    => 'Sinkronisasi nontender selesai, namun tidak ada data valid untuk diperbarui.',
                    'tahun'      => $tahun,
                    'totalData'  => PaketModel::where('tahun_anggaran', $tahun)->count(),
                ]);
            }

            $batchSize    = 1000;
            $allRups      = array_keys($incomingByRup);
            $totalUpdated = 0;

            foreach (array_chunk($allRups, $batchSize) as $rupChunk) {
                $existingRows = PaketModel::query()
                    ->select(['kd_rup', 'kd_nontender', 'status_nontender', 'hps'])
                    ->where('tahun_anggaran', $tahun)
                    ->whereIn('kd_rup', $rupChunk)
                    ->get()
                    ->keyBy('kd_rup');

                if ($existingRows->isEmpty()) {
                    continue;
                }

                foreach ($existingRows as $rup => $row) {
                    $payload = $incomingByRup[$rup] ?? null;
                    if (!$payload) {
                        continue;
                    }

                    $updateData = [
                        'updated_at' => $now,
                        'kd_nontender'      => array_key_exists('kd_nontender', $payload) ? $payload['kd_nontender'] : $row->kd_nontender,
                        'status_nontender'  => array_key_exists('status_nontender', $payload) ? $payload['status_nontender'] : $row->status_nontender,
                        'hps'               => array_key_exists('hps', $payload) ? $payload['hps'] : $row->hps,
                    ];

                    $affected = PaketModel::where('tahun_anggaran', $tahun)
                        ->where('kd_rup', $rup)
                        ->update($updateData);

                    $totalUpdated += $affected;
                }
            }

            SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);

            $totalData = PaketModel::where('tahun_anggaran', $tahun)->count();

            return back()->with([
                'success'    => "Sinkronisasi nontender berhasil! {$totalUpdated} entri diperbarui.",
                'tahun'      => $tahun,
                'totalData'  => $totalData,
            ]);
        } catch (ConnectionException $e) {
            Log::error('Tidak dapat menghubungi API LKPP (nontender): ' . $e->getMessage());
            return back()->with('error', 'Link API tidak bisa diakses. Periksa koneksi jaringan atau URL API, lalu coba lagi.');
        } catch (\Throwable $e) {
            Log::error('Sinkronisasi Nontender Gagal: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat sinkronisasi nontender: ' . $e->getMessage());
        }
    }

    public function synckontraktender(Request $request)
    {
        $id = $request->id;
        $tahun = $request->tahun;
        $lpse = config('services.lkpp.kode_lpse');
        $now   = now();
        $totalSynced = 0;

        try {
            $response = Http::get(config('services.lkpp.isb_spse_tender_pengumuman') . $tahun . ':' . $lpse);
            $data = $response->json();
            if (!is_array($data)) {
                Log::error('Data paket tender tidak valid. Response: ' . $response->body());
                return redirect()->back()->with('error', 'Data paket tender tidak valid atau kosong.');
            }

            // Ambil kd_rup yang ada di PaketModel untuk tahun ini
            $paketRups = PaketModel::where('tahun_anggaran', $tahun)
                ->pluck('kd_rup')
                ->filter()
                ->unique()
                ->toArray();

            foreach ($data as $item) {
                if (strcasecmp((string)($item['status_tender'] ?? ''), 'Selesai') !== 0) {
                    continue;
                }

                $kdRup    = $item['kd_rup'] ?? null;
                $kdTender = $item['kd_tender'] ?? null;

                if (!$kdRup || !$kdTender || !in_array($kdRup, $paketRups)) {
                    continue;
                }

                KontrakModel::updateOrCreate(
                    ['kd_rup' => $kdRup],
                    [
                        'tahun_anggaran' => $item['tahun_anggaran'] ?? $tahun,
                        'kd_tender'      => $kdTender,
                    ]
                );
                $totalSynced++;
            }
            // Update data kontrak tender
            $response1 = Http::get(config('services.lkpp.isb_spse_tender_kontrak') . $tahun . ':' . $lpse);
            $data1 = $response1->json();

            if (!is_array($data1)) {
                Log::error('Data kontrak tender tidak valid. Response: ' . $response1->body());
                return redirect()->back()->with('error', 'Data kontrak tender tidak valid atau kosong.');
            }

            foreach ($data1 as $item1) {
                if (empty($item1['kd_tender'])) {
                    continue;
                }
                // Cari kd_rup dari PaketModel berdasarkan kd_tender
                $kdRup = PaketModel::where('kd_tender', $item1['kd_tender'])->value('kd_rup');
                if (!$kdRup || !in_array($kdRup, $paketRups)) {
                    continue;
                }
                $raw = $item1['tgl_kontrak'] ?? null;
                $tgl = $raw ? Carbon::parse($raw)->tz('Asia/Jayapura')->toDateString() : null;

                KontrakModel::where('kd_rup', $kdRup)
                    ->update([
                        'no_kontrak'   => $item1['no_kontrak'] ?? null,
                        'tgl_kontrak'  => $tgl,
                        'wakil_sah_penyedia' => $item1['wakil_sah_penyedia'] ?? null,
                    ]);

                $totalSynced++;
            }

            // Update data SPMK tender
            $response2 = Http::get(config('services.lkpp.isb_spse_tender_spmk') . $tahun . ':' . $lpse);
            $data2 = $response2->json();

            if (!is_array($data2)) {
                Log::error('Data SPMK tender tidak valid. Response: ' . $response2->body());
                return redirect()->back()->with('error', 'Data SPMK tender tidak valid atau kosong.');
            }

            foreach ($data2 as $item2) {
                if (empty($item2['kd_tender'])) {
                    continue;
                }
                $kdRup = PaketModel::where('kd_tender', $item2['kd_tender'])->value('kd_rup');
                if (!$kdRup || !in_array($kdRup, $paketRups)) {
                    continue;
                }
                KontrakModel::where('kd_rup', $kdRup)
                    ->update([
                        'waktu_pelaksanaan' => $item2['waktu_penyelesaian'] ?? null
                    ]);

                $totalSynced++;
            }

            // Update data selesai tender
            $response3 = Http::get(config('services.lkpp.isb_spse_tender_selesai') . $tahun . ':' . $lpse);
            $data3 = $response3->json();

            if (!is_array($data3)) {
                Log::error('Data selesai tender tidak valid. Response: ' . $response3->body());
                return redirect()->back()->with('error', 'Data selesai tender tidak valid atau kosong.');
            }

            foreach ($data3 as $item3) {
                if (empty($item3['kd_tender'])) {
                    continue;
                }
                $kdRup = PaketModel::where('kd_tender', $item3['kd_tender'])->value('kd_rup');
                if (!$kdRup || !in_array($kdRup, $paketRups)) {
                    continue;
                }
                KontrakModel::where('kd_rup', $kdRup)
                    ->update([
                        'nilai_penawaran' => $item3['nilai_penawaran'] ?? null,
                        'nilai_kontrak'    => $item3['nilai_kontrak'] ?? null,
                        'nama_penyedia'    => $item3['nama_penyedia'] ?? null,
                        'npwp_penyedia'    => $item3['npwp_penyedia'] ?? null,
                    ]);
                $totalSynced++;
            }

            SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);
            $totalData = KontrakModel::where('tahun_anggaran', $tahun)->count();

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
        $tahun = $request->tahun;
        $lpse = config('services.lkpp.kode_lpse');
        $now   = now();
        $totalSynced = 0;

        try {
            $response = Http::get(config('services.lkpp.isb_spse_nontender_pengumuman') . $tahun . ':' . $lpse);
            $data = $response->json();
            if (!is_array($data)) {
                Log::error('Data paket nontender tidak valid. Response: ' . $response->body());
                return redirect()->back()->with('error', 'Data paket nontender tidak valid atau kosong.');
            }

            // Ambil kd_rup yang ada di PaketModel untuk tahun ini
            $paketRups = PaketModel::where('tahun_anggaran', $tahun)
                ->pluck('kd_rup')
                ->filter()
                ->unique()
                ->toArray();

            foreach ($data as $item) {
                if (empty($item['kd_rup']) || empty($item['kd_nontender']) || !in_array($item['kd_rup'], $paketRups)) {
                    continue;
                }
                KontrakModel::updateOrCreate(
                    ['kd_rup' => $item['kd_rup']],
                    [
                        'tahun_anggaran' => $item['tahun_anggaran'] ?? $tahun,
                        'kd_nontender' => $item['kd_nontender'],
                    ]
                );
                $totalSynced++;
            }

            // Update data kontrak nontender
            $response1 = Http::get(config('services.lkpp.isb_spse_nontender_kontrak') . $tahun . ':' . $lpse);
            $data1 = $response1->json();

            if (!is_array($data1)) {
                Log::error('Data kontrak nontender tidak valid. Response: ' . $response1->body());
                return redirect()->back()->with('error', 'Data kontrak nontender tidak valid atau kosong.');
            }

            foreach ($data1 as $item1) {
                if (empty($item1['kd_nontender'])) {
                    continue;
                }
                // Cari kd_rup dari PaketModel berdasarkan kd_nontender
                $kdRup = PaketModel::where('kd_nontender', $item1['kd_nontender'])->value('kd_rup');
                if (!$kdRup || !in_array($kdRup, $paketRups)) {
                    continue;
                }
                $raw = $item1['tgl_kontrak'] ?? null;
                $tgl = $raw ? Carbon::parse($raw)->tz('Asia/Jayapura')->toDateString() : null;

                KontrakModel::where('kd_rup', $kdRup)
                    ->update([
                        'tahun_anggaran'   => $item1['tahun_anggaran'] ?? $tahun,
                        'no_kontrak'       => $item1['no_kontrak'] ?? null,
                        'tgl_kontrak'      => $tgl,
                        'wakil_sah_penyedia' => $item1['wakil_sah_penyedia'] ?? null,
                    ]);

                $totalSynced++;
            }

            // Update data SPMK nontender
            $response2 = Http::get(config('services.lkpp.isb_spse_nontender_spmk') . $tahun . ':' . $lpse);
            $data2 = $response2->json();

            if (!is_array($data2)) {
                Log::error('Data SPMK nontender tidak valid. Response: ' . $response2->body());
                return redirect()->back()->with('error', 'Data SPMK nontender tidak valid atau kosong.');
            }

            foreach ($data2 as $item2) {
                if (empty($item2['kd_nontender'])) {
                    continue;
                }
                $kdRup = PaketModel::where('kd_nontender', $item2['kd_nontender'])->value('kd_rup');
                if (!$kdRup || !in_array($kdRup, $paketRups)) {
                    continue;
                }
                KontrakModel::where('kd_rup', $kdRup)
                    ->update([
                        'waktu_pelaksanaan' => $item2['waktu_penyelesaian'] ?? null
                    ]);

                $totalSynced++;
            }

            // Update data selesai nontender
            $response3 = Http::get(config('services.lkpp.isb_spse_nontender_selesai') . $tahun . ':' . $lpse);
            $data3 = $response3->json();

            if (!is_array($data3)) {
                Log::error('Data selesai nontender tidak valid. Response: ' . $response3->body());
                return redirect()->back()->with('error', 'Data selesai nontender tidak valid atau kosong.');
            }

            foreach ($data3 as $item3) {
                if (empty($item3['kd_nontender'])) {
                    continue;
                }
                $kdRup = PaketModel::where('kd_nontender', $item3['kd_nontender'])->value('kd_rup');
                if (!$kdRup || !in_array($kdRup, $paketRups)) {
                    continue;
                }
                KontrakModel::where('kd_rup', $kdRup)
                    ->update([
                        'nilai_penawaran' => $item3['nilai_penawaran'] ?? null,
                        'nilai_kontrak'    => $item3['nilai_kontrak'] ?? null,
                        'nama_penyedia'    => $item3['nama_penyedia'] ?? null,
                        'npwp_penyedia'    => $item3['npwp_penyedia'] ?? null,
                    ]);

                $totalSynced++;
            }

            SyncdataModel::whereKey($id)->update(['last_synced_at' => $now]);
            $totalData = KontrakModel::where('tahun_anggaran', $tahun)->count();

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

    public function syncdatapenyedia()
    {
        try {
            $npwpList = KontrakModel::select('npwp_penyedia', 'nama_penyedia')
                ->whereNotNull('npwp_penyedia')
                ->distinct()
                ->get();

            $totalSynced = 0;

            foreach ($npwpList as $item) {
                if ($item->npwp_penyedia) {
                    $exists = PenyediaModel::where('npwp_penyedia', $item->npwp_penyedia)->exists();

                    if (!$exists) {
                        PenyediaModel::create([
                            'npwp_penyedia' => $item->npwp_penyedia,
                            'nama_penyedia' => $item->nama_penyedia
                        ]);
                        $totalSynced++;
                    }
                }
            }

            return redirect()->back()->with('success', "Sinkronisasi data penyedia selesai. Total {$totalSynced} NPWP baru ditambahkan.");
        } catch (\Exception $e) {
            Log::error('Sinkronisasi Data Penyedia Gagal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat sinkronisasi data penyedia: ' . $e->getMessage());
        }
    }

    public function syncdatapenyediasikap()
    {
        $totalSynced = 0;
        $totalSkipped = 0;
        $batchSize = 20;

        PenyediaModel::select('id', 'npwp_penyedia')->chunkById($batchSize, function ($penyediaBatch) use (&$totalSynced, &$totalSkipped) {
            $requests = [];
            foreach ($penyediaBatch as $penyedia) {
                if (!empty($penyedia->npwp_penyedia)) {
                    $requests[$penyedia->id] = config('services.lkpp.isb_sikap_penyedia') . $penyedia->npwp_penyedia;
                }
            }

            $responses = Http::pool(
                fn($pool) =>
                collect($requests)->map(
                    fn($url, $id) =>
                    $pool->as($id)->timeout(30)->retry(2, 100)->acceptJson()->get($url)
                )->toArray()
            );

            foreach ($penyediaBatch as $penyedia) {
                $response = $responses[$penyedia->id] ?? null;

                if ($response && $response->successful() && !empty($response->json())) {
                    $item = $response->json()[0] ?? [];
                    if (empty($item['kd_penyedia'])) {
                        $totalSkipped++;
                        continue;
                    }

                    $parseDate = fn($tgl) => !empty($tgl) ? optional(Carbon::parse($tgl)->tz('Asia/Jayapura'))->toDateString() : null;
                    $tglDaftar = $parseDate($item['tgl_daftar_sikap'] ?? null);
                    $tglPersetujuan = $parseDate($item['tgl_persetujuan_verifikasi_daftar_sikap'] ?? null);
                    PenyediaModel::where('id', $penyedia->id)->update([
                        'kd_penyedia' => $item['kd_penyedia'] ?? null,
                        'nama_penyedia' => isset($item['nama_penyedia']) ? strtoupper($item['nama_penyedia']) : null,
                        'bentuk_usaha' => $item['bentuk_usaha'] ?? null,
                        'alamat' => $item['alamat'] ?? null,
                        'kabupaten' => $item['kabupaten'] ?? null,
                        'provinsi' => $item['provinsi'] ?? null,
                        'kodepos' => $item['kodepos'] ?? null,
                        'telepon' => $item['telepon'] ?? null,
                        'fax' => $item['fax'] ?? null,
                        'email' => $item['email'] ?? null,
                        'website' => $item['website'] ?? null,
                        'nomor_pkp' => $item['nomor_pkp'] ?? null,
                        'status_npwp' => $item['status_npwp'] ?? null,
                        'status_kswp' => $item['status_kswp'] ?? null,
                        'status_pelaku_usaha' => $item['status_pelaku_usaha'] ?? null,
                        'alamat_pusat' => $item['alamat_pusat'] ?? null,
                        'telepon_pusat' => $item['telepon_pusat'] ?? null,
                        'fax_pusat' => $item['fax_pusat'] ?? null,
                        'email_pusat' => $item['email_pusat'] ?? null,
                        'tgl_daftar_sikap' => $tglDaftar,
                        'tgl_persetujuan_verifikasi_daftar_sikap' => $tglPersetujuan,
                        'setuju_publikasi_data' => $item['setuju_publikasi_data'] ?? null,
                        'npwp16_penyedia' => $item['npwp16_penyedia'] ?? null,
                        'updated_at' => now(),
                    ]);
                    $totalSynced++;
                } else {
                    $totalSkipped++;
                }
            }
        });

        return redirect()->back()->with('success', "Sinkronisasi selesai. {$totalSynced} data berhasil diperbarui, {$totalSkipped} data dilewati.");
    }

    public function syncpenyediasikap(Request $request)
    {
        $npwp = $request->npwp_penyedia;

        try {
            $response = Http::timeout(60)
                ->retry(3, 200)
                ->acceptJson()
                ->get(config('services.lkpp.isb_sikap_penyedia') . $npwp);

            $data = $response->json();

            if ($response->successful() && !empty($data)) {
                $item = $data[0] ?? [];

                if (!empty($item['kd_penyedia'])) {
                    $parseDate = fn($tgl) => !empty($tgl) ? optional(Carbon::parse($tgl)->tz('Asia/Jayapura'))->toDateString() : null;
                    $tglDaftar = $parseDate($item['tgl_daftar_sikap'] ?? null);
                    $tglPersetujuan = $parseDate($item['tgl_persetujuan_verifikasi_daftar_sikap'] ?? null);

                    PenyediaModel::where('npwp_penyedia', $npwp)->update([
                        'kd_penyedia' => $item['kd_penyedia'] ?? null,
                        'nama_penyedia' => isset($item['nama_penyedia']) ? strtoupper($item['nama_penyedia']) : null,
                        'bentuk_usaha' => $item['bentuk_usaha'] ?? null,
                        'alamat' => $item['alamat'] ?? null,
                        'kabupaten' => $item['kabupaten'] ?? null,
                        'provinsi' => $item['provinsi'] ?? null,
                        'kodepos' => $item['kodepos'] ?? null,
                        'telepon' => $item['telepon'] ?? null,
                        'fax' => $item['fax'] ?? null,
                        'email' => $item['email'] ?? null,
                        'website' => $item['website'] ?? null,
                        'nomor_pkp' => $item['nomor_pkp'] ?? null,
                        'status_npwp' => $item['status_npwp'] ?? null,
                        'status_kswp' => $item['status_kswp'] ?? null,
                        'status_pelaku_usaha' => $item['status_pelaku_usaha'] ?? null,
                        'alamat_pusat' => $item['alamat_pusat'] ?? null,
                        'telepon_pusat' => $item['telepon_pusat'] ?? null,
                        'fax_pusat' => $item['fax_pusat'] ?? null,
                        'email_pusat' => $item['email_pusat'] ?? null,
                        'tgl_daftar_sikap' => $tglDaftar,
                        'tgl_persetujuan_verifikasi_daftar_sikap' => $tglPersetujuan,
                        'setuju_publikasi_data' => $item['setuju_publikasi_data'] ?? null,
                        'npwp16_penyedia' => $item['npwp16_penyedia'] ?? null,
                        'updated_at' => now(),
                    ]);

                    return redirect()->back()->with('success', 'Data penyedia berhasil diperbarui.');
                } else {
                    return redirect()->back()->with('error', 'Data penyedia tidak ditemukan atau tidak valid.');
                }
            } else {
                Log::error("Gagal mengakses API SIKAP untuk NPWP: {$npwp}, Status: {$response->status()}, Body: " . $response->body());
                return redirect()->back()->with('error', "Tidak dapat mengakses API SIKAP (status {$response->status()}). Silakan coba lagi nanti.");
            }
        } catch (ConnectionException $e) {
            Log::error('Tidak dapat menghubungi API SIKAP untuk NPWP: ' . $npwp . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Link API tidak bisa diakses. Periksa koneksi jaringan atau URL API, lalu coba lagi.');
        } catch (\Throwable $e) {
            Log::error('Sinkronisasi SIKAP Penyedia Gagal untuk NPWP: ' . $npwp . ' - ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat sinkronisasi: ' . $e->getMessage());
        }
    }
}
