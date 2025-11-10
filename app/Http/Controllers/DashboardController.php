<?php

namespace App\Http\Controllers;

use App\Models\BidangModel;
use App\Models\PaketModel;
use App\Models\PenyediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (($user->role == 'Admin')) {
            $tahun = $request->input('tahun', date('Y'));
            $bidang = $request->input('bidang');

            $statusFilter = function ($q) {
                $q->where(function ($subQ) {
                    $subQ->whereNull('paket.status_nontender')
                        ->orWhere('paket.status_nontender', '!=', 'Gagal/Batal');
                })->orWhere(function ($subQ) {
                    $subQ->whereNull('paket.status_tender')
                        ->orWhere('paket.status_tender', '!=', 'Gagal/Batal');
                });
            };

            $totalpaket = PaketModel::where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
                ->where('tahun_anggaran', $tahun)
                ->where($statusFilter)
                ->when($bidang && $bidang != '', function ($query) use ($bidang) {
                    return $query->where('paket.bidang', $bidang);
                })
                ->count();
            $totalpengadaan = PaketModel::where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
                ->where('jenis_pengadaan', 'Barang')
                ->where('tahun_anggaran', $tahun)
                ->where($statusFilter)
                ->when($bidang && $bidang != '', function ($query) use ($bidang) {
                    return $query->where('paket.bidang', $bidang);
                })
                ->count();
            $totalkonstruksi = PaketModel::where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
                ->where('jenis_pengadaan', 'Pekerjaan Konstruksi')
                ->where('tahun_anggaran', $tahun)
                ->where($statusFilter)
                ->when($bidang && $bidang != '', function ($query) use ($bidang) {
                    return $query->where('paket.bidang', $bidang);
                })
                ->count();
            $totallainnya = PaketModel::where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
                ->where('jenis_pengadaan', 'Jasa Lainnya')
                ->where('tahun_anggaran', $tahun)
                ->where($statusFilter)
                ->when($bidang && $bidang != '', function ($query) use ($bidang) {
                    return $query->where('paket.bidang', $bidang);
                })
                ->count();
            $totalkonsultansi = PaketModel::where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
                ->where('jenis_pengadaan', 'Jasa Konsultansi')
                ->where('tahun_anggaran', $tahun)
                ->where($statusFilter)
                ->when($bidang && $bidang != '', function ($query) use ($bidang) {
                    return $query->where('paket.bidang', $bidang);
                })
                ->count();
            $totalpenyedia = PenyediaModel::count();
            $totalpenyediaoap = PenyediaModel::where('oap', 1)->count();
            $totalpenyedianonoap = PenyediaModel::where('oap', 0)->count();
            $tahunanggaran = PaketModel::select('tahun_anggaran')
                ->distinct()
                ->orderBy('tahun_anggaran', 'desc')
                ->get()
                ->pluck('tahun_anggaran');
            $toppenyedia = PaketModel::select(
                'penyedia.nama_penyedia',
                'penyedia.oap',
                DB::raw('COUNT(paket.kd_rup) as jumlah_paket'),
                DB::raw('SUM(kontrak.nilai_kontrak) as total_nilai'),
                DB::raw('SUM(CASE WHEN paket.kd_tender IS NOT NULL THEN 1 ELSE 0 END) as tender_count'),
                DB::raw('SUM(CASE WHEN paket.kd_nontender IS NOT NULL THEN 1 ELSE 0 END) as non_tender_count')
            )
                ->leftJoin('kontrak', 'paket.kd_rup', '=', 'kontrak.kd_rup')
                ->leftJoin('penyedia', 'kontrak.npwp_penyedia', '=', 'penyedia.npwp_penyedia')
                ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
                ->where('paket.tahun_anggaran', $tahun)
                ->where($statusFilter)
                ->when($bidang && $bidang != '', function ($query) use ($bidang) {
                    return $query->where('paket.bidang', $bidang);
                })
                ->whereNotNull('penyedia.nama_penyedia')
                ->groupBy('penyedia.nama_penyedia', 'penyedia.oap')
                ->orderBy('jumlah_paket', 'desc')
                ->limit(10)
                ->get();
            $bidangpaket = BidangModel::select(
                DB::raw('COALESCE(bidang.nama_bidang, "Bidang Belum Ditentukan") as nama_bidang'),
                DB::raw('COUNT(paket.kd_rup) as total_paket'),
                DB::raw('SUM(paket.pagu) as total_pagu'),
                DB::raw('SUM(CASE WHEN paket.jenis_pengadaan = "Barang" THEN 1 ELSE 0 END) as barang'),
                DB::raw('SUM(CASE WHEN paket.jenis_pengadaan = "Pekerjaan Konstruksi" THEN 1 ELSE 0 END) as pekerjaan_konstruksi'),
                DB::raw('SUM(CASE WHEN paket.jenis_pengadaan = "Jasa Lainnya" THEN 1 ELSE 0 END) as jasa_lainnya'),
                DB::raw('SUM(CASE WHEN paket.jenis_pengadaan = "Jasa Konsultansi" THEN 1 ELSE 0 END) as jasa_konsultansi')
            )
                ->where($statusFilter)
                ->rightJoin('paket', 'bidang.nama_bidang', '=', 'paket.bidang')
                ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
                ->where('paket.tahun_anggaran', $tahun)
                ->groupBy(DB::raw('COALESCE(bidang.nama_bidang, "Bidang Belum Ditentukan")'))
                ->orderByRaw('COUNT(paket.kd_rup) ASC')
                ->get();

            $data = [
                'title' => 'Dashboard',
                'active' => 'dashboard',
                'totalpaket' => $totalpaket,
                'totalpengadaan' => $totalpengadaan,
                'totalkonstruksi' => $totalkonstruksi,
                'totallainnya' => $totallainnya,
                'totalkonsultansi' => $totalkonsultansi,
                'totalpenyedia' => $totalpenyedia,
                'totalpenyediaoap' => $totalpenyediaoap,
                'totalpenyedianonoap' => $totalpenyedianonoap,
                'tahunanggaran' => $tahunanggaran,
                'toppenyedia' => $toppenyedia,
                'selectedtahun' => $tahun,
                'bidangpaket' => $bidangpaket,
                'selectedbidang' => $bidang,
                'bidanglist' => BidangModel::all(),
            ];

            return view('admin.dashboard', $data);
        } elseif (($user->role == 'User')) {
            $data = [
                'title' => 'Dashboard',
                'active' => 'dashboard',
            ];
            return view('user.dashboard', $data);
        }
    }
}
