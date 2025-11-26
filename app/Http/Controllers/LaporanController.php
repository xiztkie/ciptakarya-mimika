<?php

namespace App\Http\Controllers;

use App\Exports\ExcellLaporanpaket;
use App\Exports\ExcellLaporanperpenyedia;
use App\Models\BidangModel;
use App\Models\PaketModel;
use App\Models\PenyediaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function laporanpaket(Request $request)
    {
        $statusFilter = function ($q) {
            $q->where(function ($subQ) {
                $subQ->whereNull('paket.status_nontender')
                    ->orWhere('paket.status_nontender', '!=', 'Gagal/Batal');
            })->orWhere(function ($subQ) {
                $subQ->whereNull('paket.status_tender')
                    ->orWhere('paket.status_tender', '!=', 'Gagal/Batal');
            });
        };

        $query = PaketModel::query()
            ->leftJoin('kontrak', 'paket.kd_rup', '=', 'kontrak.kd_rup')
            ->leftJoin('penyedia', 'kontrak.npwp_penyedia', '=', 'penyedia.npwp_penyedia')
            ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
            ->where($statusFilter)
            ->select(
                'paket.*',
                'kontrak.no_kontrak',
                'kontrak.tgl_kontrak',
                'kontrak.nilai_kontrak',
                'kontrak.nilai_penawaran',
                'penyedia.nama_penyedia',
                'kontrak.npwp_penyedia',
                'kontrak.wakil_sah_penyedia',
                'kontrak.waktu_pelaksanaan',
                'penyedia.kd_penyedia',
                'penyedia.oap'
            );

        if ($request->has('tahun_anggaran') && $request->input('tahun_anggaran') != '') {
            $query->where('paket.tahun_anggaran', $request->input('tahun_anggaran'));
        }

        if ($request->has('bidang') && $request->input('bidang') != '') {
            $query->where('paket.bidang', $request->input('bidang'));
        }

        if ($request->has('metode_pengadaan') && $request->input('metode_pengadaan') != '') {
            $query->where('paket.metode_pengadaan', $request->input('metode_pengadaan'));
        }

        if ($request->has('jenis_pengadaan') && $request->input('jenis_pengadaan') != '') {
            $query->where('paket.jenis_pengadaan', $request->input('jenis_pengadaan'));
        }

        if ($request->has('tipe_pengadaan') && $request->input('tipe_pengadaan') != '') {
            $tipe = $request->input('tipe_pengadaan');
            if ($tipe === 'tender') {
                $query->whereNotNull('paket.kd_tender');
            } elseif ($tipe === 'nontender') {
                $query->whereNotNull('paket.kd_nontender');
            }
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('paket.nama_paket', 'like', '%' . $search . '%')
                    ->orWhere('penyedia.nama_penyedia', 'like', '%' . $search . '%');
            });
        }

        $paket =  $query->paginate(30);
        $tahunanggaran = PaketModel::select('tahun_anggaran')->distinct()->orderBy('tahun_anggaran', 'desc')->get();
        $jenispengadaan = PaketModel::select('jenis_pengadaan')->where('kd_satker_str', '1.03.0.00.0.00.01.0000')->distinct()->get();
        $metodepengadaan = PaketModel::select('metode_pengadaan')->distinct()->get();

        $data = [
            'title' => 'Data Paket',
            'paket' => $paket,
            'tahunanggaran' => $tahunanggaran,
            'jenispengadaan' => $jenispengadaan,
            'metodepengadaan' => $metodepengadaan,
            'search' => $request->input('search'),
            'bidang' => BidangModel::all(),
        ];

        return view('laporan.laporanpaket', $data);
    }

    public function exportpdflaporanpaket(Request $request)
    {
        $statusFilter = function ($q) {
            $q->where(function ($subQ) {
                $subQ->whereNull('paket.status_nontender')
                    ->orWhere('paket.status_nontender', '!=', 'Gagal/Batal');
            })->orWhere(function ($subQ) {
                $subQ->whereNull('paket.status_tender')
                    ->orWhere('paket.status_tender', '!=', 'Gagal/Batal');
            });
        };

        $query = PaketModel::query()
            ->leftJoin('kontrak', 'paket.kd_rup', '=', 'kontrak.kd_rup')
            ->leftJoin('penyedia', 'kontrak.npwp_penyedia', '=', 'penyedia.npwp_penyedia')
            ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
            ->where($statusFilter)
            ->select(
                'paket.*',
                'kontrak.no_kontrak',
                'kontrak.tgl_kontrak',
                'kontrak.nilai_kontrak',
                'kontrak.nilai_penawaran',
                'penyedia.nama_penyedia',
                'kontrak.npwp_penyedia',
                'kontrak.wakil_sah_penyedia',
                'kontrak.waktu_pelaksanaan',
                'penyedia.kd_penyedia',
                'penyedia.oap'
            );

        if ($request->has('tahun_anggaran') && $request->input('tahun_anggaran') != '') {
            $query->where('paket.tahun_anggaran', $request->input('tahun_anggaran'));
        }

        if ($request->has('bidang') && $request->input('bidang') != '') {
            $query->where('paket.bidang', $request->input('bidang'));
        }

        if ($request->has('metode_pengadaan') && $request->input('metode_pengadaan') != '') {
            $query->where('paket.metode_pengadaan', $request->input('metode_pengadaan'));
        }

        if ($request->has('jenis_pengadaan') && $request->input('jenis_pengadaan') != '') {
            $query->where('paket.jenis_pengadaan', $request->input('jenis_pengadaan'));
        }

        if ($request->has('tipe_pengadaan') && $request->input('tipe_pengadaan') != '') {
            $tipe = $request->input('tipe_pengadaan');
            if ($tipe === 'tender') {
                $query->whereNotNull('paket.kd_tender');
            } elseif ($tipe === 'nontender') {
                $query->whereNotNull('paket.kd_nontender');
            }
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('paket.nama_paket', 'like', '%' . $search . '%')
                    ->orWhere('penyedia.nama_penyedia', 'like', '%' . $search . '%');
            });
        }

        $paket =  $query->get();
        $tahunanggaran = PaketModel::select('tahun_anggaran')->distinct()->orderBy('tahun_anggaran', 'desc')->get();

        $data = [
            'title' => 'Data Paket',
            'paket' => $paket,
        ];


        $pdf = Pdf::loadView('laporan.laporanpaketpdf', $data)
            ->setPaper([0, 0, 793, 1247], 'landscape');

        Carbon::setLocale('id');
        $printedAt = Carbon::now('Asia/Jayapura')->translatedFormat('d F Y H:i');

        $dompdf = $pdf->getDomPDF();
        $dompdf->render();

        $canvas = $dompdf->get_canvas();
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        $fontMetrics = $dompdf->getFontMetrics();
        $font = $fontMetrics->get_font('helvetica', 'normal');
        $size = 8;
        $color = [108 / 255, 117 / 255, 125 / 255];

        $object = $canvas->open_object();

        $leftText = "Dicetak melalui App pada {$printedAt}";
        $canvas->page_text(12, $h - 18, $leftText, $font, $size, $color);

        $rightText = "Halaman {PAGE_NUM} / {PAGE_COUNT}";
        $rightWidth = $fontMetrics->get_text_width($rightText, $font, $size);
        $canvas->page_text($w - $rightWidth - 12, $h - 18, $rightText, $font, $size, $color);

        $canvas->close_object();
        $canvas->add_object($object, 'all');

        $filename = 'laporanpaket_' . now('Asia/Jayapura')->format('YmdHis') . '.pdf';
        return $pdf->stream($filename);
    }

    public function exportexcelaporanpaket(Request $request)
    {
        $statusFilter = function ($q) {
            $q->where(function ($subQ) {
                $subQ->whereNull('paket.status_nontender')
                    ->orWhere('paket.status_nontender', '!=', 'Gagal/Batal');
            })->orWhere(function ($subQ) {
                $subQ->whereNull('paket.status_tender')
                    ->orWhere('paket.status_tender', '!=', 'Gagal/Batal');
            });
        };

        $query = PaketModel::query()
            ->leftJoin('kontrak', 'paket.kd_rup', '=', 'kontrak.kd_rup')
            ->leftJoin('penyedia', 'kontrak.npwp_penyedia', '=', 'penyedia.npwp_penyedia')
            ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
            ->where($statusFilter)
            ->select(
                'paket.*',
                'kontrak.no_kontrak',
                'kontrak.tgl_kontrak',
                'kontrak.nilai_kontrak',
                'kontrak.nilai_penawaran',
                'penyedia.nama_penyedia',
                'kontrak.npwp_penyedia',
                'kontrak.wakil_sah_penyedia',
                'kontrak.waktu_pelaksanaan',
                'penyedia.kd_penyedia',
                'penyedia.oap'
            );

        if ($request->has('tahun_anggaran') && $request->input('tahun_anggaran') != '') {
            $query->where('paket.tahun_anggaran', $request->input('tahun_anggaran'));
        }

        if ($request->has('bidang') && $request->input('bidang') != '') {
            $query->where('paket.bidang', $request->input('bidang'));
        }

        if ($request->has('metode_pengadaan') && $request->input('metode_pengadaan') != '') {
            $query->where('paket.metode_pengadaan', $request->input('metode_pengadaan'));
        }

        if ($request->has('jenis_pengadaan') && $request->input('jenis_pengadaan') != '') {
            $query->where('paket.jenis_pengadaan', $request->input('jenis_pengadaan'));
        }

        if ($request->has('tipe_pengadaan') && $request->input('tipe_pengadaan') != '') {
            $tipe = $request->input('tipe_pengadaan');
            if ($tipe === 'tender') {
                $query->whereNotNull('paket.kd_tender');
            } elseif ($tipe === 'nontender') {
                $query->whereNotNull('paket.kd_nontender');
            }
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('paket.nama_paket', 'like', '%' . $search . '%')
                    ->orWhere('penyedia.nama_penyedia', 'like', '%' . $search . '%');
            });
        }

        $paket =  $query->get();

        $data = [
            'title' => 'Data Paket',
            'paket' => $paket,
        ];

        return Excel::download(new ExcellLaporanpaket($data), 'laporan_paket_' . now('Asia/Jayapura')->format('YmdHis') . '.xlsx');
    }

    public function laporanperpenyedia(Request $request)
    {
        $statusFilter = function ($q) {
            $q->where(function ($subQ) {
                $subQ->whereNull('paket.status_nontender')
                    ->orWhere('paket.status_nontender', '!=', 'Gagal/Batal');
            })->orWhere(function ($subQ) {
                $subQ->whereNull('paket.status_tender')
                    ->orWhere('paket.status_tender', '!=', 'Gagal/Batal');
            });
        };

        $paket = PaketModel::query()
            ->leftJoin('kontrak', 'paket.kd_rup', '=', 'kontrak.kd_rup')
            ->leftJoin('penyedia', 'kontrak.npwp_penyedia', '=', 'penyedia.npwp_penyedia')
            ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
            ->where($statusFilter)
            ->select(
                'paket.*',
                'kontrak.no_kontrak',
                'kontrak.tgl_kontrak',
                'kontrak.nilai_kontrak',
                'kontrak.nilai_penawaran',
                'penyedia.nama_penyedia',
                'kontrak.npwp_penyedia',
                'kontrak.wakil_sah_penyedia',
                'kontrak.waktu_pelaksanaan',
                'penyedia.kd_penyedia',
                'penyedia.oap'
            );

        if ($request->has('tahun_anggaran') && $request->input('tahun_anggaran') != '') {
            $paket->where('paket.tahun_anggaran', $request->input('tahun_anggaran'));
        }

        if ($request->has('bidang') && $request->input('bidang') != '') {
            $paket->where('paket.bidang', $request->input('bidang'));
        }

        $paket =  $paket->get();

        $vendor = PenyediaModel::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $vendor->where(function ($q) use ($search) {
                $q->where('penyedia.nama_penyedia', 'like', '%' . $search . '%');
            });
        }

        $vendor = $vendor->paginate(30);
        $tahunanggaran = PaketModel::select('tahun_anggaran')->distinct()->orderBy('tahun_anggaran', 'desc')->get();
        $data = [
            'title' => 'Laporan Per Penyedia',
            'paket' => $paket,
            'vendor' => $vendor,
            'search' => $request->input('search'),
            'tahunanggaran' => $tahunanggaran,
            'bidang' => BidangModel::all(),
        ];

        return view('laporan.laporanperpenyedia', $data);
    }

    public function exportpdflaporanperpenyedia(Request $request)
    {
        $statusFilter = function ($q) {
            $q->where(function ($subQ) {
                $subQ->whereNull('paket.status_nontender')
                    ->orWhere('paket.status_nontender', '!=', 'Gagal/Batal');
            })->orWhere(function ($subQ) {
                $subQ->whereNull('paket.status_tender')
                    ->orWhere('paket.status_tender', '!=', 'Gagal/Batal');
            });
        };

        $paket = PaketModel::query()
            ->leftJoin('kontrak', 'paket.kd_rup', '=', 'kontrak.kd_rup')
            ->leftJoin('penyedia', 'kontrak.npwp_penyedia', '=', 'penyedia.npwp_penyedia')
            ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
            ->where($statusFilter)
            ->select(
                'paket.*',
                'kontrak.no_kontrak',
                'kontrak.tgl_kontrak',
                'kontrak.nilai_kontrak',
                'kontrak.nilai_penawaran',
                'penyedia.nama_penyedia',
                'kontrak.npwp_penyedia',
                'kontrak.wakil_sah_penyedia',
                'kontrak.waktu_pelaksanaan',
                'penyedia.kd_penyedia',
                'penyedia.oap'
            );

        if ($request->has('tahun_anggaran') && $request->input('tahun_anggaran') != '') {
            $paket->where('paket.tahun_anggaran', $request->input('tahun_anggaran'));
        }

        if ($request->has('bidang') && $request->input('bidang') != '') {
            $paket->where('paket.bidang', $request->input('bidang'));
        }

        $paket =  $paket->get();

        $vendor = PenyediaModel::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $vendor->where(function ($q) use ($search) {
                $q->where('penyedia.nama_penyedia', 'like', '%' . $search . '%');
            });
        }

        $vendor = $vendor->get();
        $data = [
            'title' => 'Laporan Per Penyedia',
            'paket' => $paket,
            'vendor' => $vendor,
        ];

        $pdf = Pdf::loadView('laporan.laporanperpenyediapdf', $data)
            ->setPaper([0, 0, 793, 1247], 'landscape');

        Carbon::setLocale('id');
        $printedAt = Carbon::now('Asia/Jayapura')->translatedFormat('d F Y H:i');

        $dompdf = $pdf->getDomPDF();
        $dompdf->render();

        $canvas = $dompdf->get_canvas();
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        $fontMetrics = $dompdf->getFontMetrics();
        $font = $fontMetrics->get_font('helvetica', 'normal');
        $size = 8;
        $color = [108 / 255, 117 / 255, 125 / 255];

        $object = $canvas->open_object();

        $leftText = "Dicetak melalui App pada {$printedAt}";
        $canvas->page_text(12, $h - 18, $leftText, $font, $size, $color);

        $rightText = "Halaman {PAGE_NUM} / {PAGE_COUNT}";
        $rightWidth = $fontMetrics->get_text_width($rightText, $font, $size);
        $canvas->page_text($w - $rightWidth - 12, $h - 18, $rightText, $font, $size, $color);

        $canvas->close_object();
        $canvas->add_object($object, 'all');

        $filename = 'laporanperpenyedia_' . now('Asia/Jayapura')->format('YmdHis') . '.pdf';
        return $pdf->stream($filename);
    }

    public function exportexcelaporanperpenyedia(Request $request)
    {
        $statusFilter = function ($q) {
            $q->where(function ($subQ) {
                $subQ->whereNull('paket.status_nontender')
                    ->orWhere('paket.status_nontender', '!=', 'Gagal/Batal');
            })->orWhere(function ($subQ) {
                $subQ->whereNull('paket.status_tender')
                    ->orWhere('paket.status_tender', '!=', 'Gagal/Batal');
            });
        };

        $paket = PaketModel::query()
            ->leftJoin('kontrak', 'paket.kd_rup', '=', 'kontrak.kd_rup')
            ->leftJoin('penyedia', 'kontrak.npwp_penyedia', '=', 'penyedia.npwp_penyedia')
            ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
            ->where($statusFilter)
            ->select(
                'paket.*',
                'kontrak.no_kontrak',
                'kontrak.tgl_kontrak',
                'kontrak.nilai_kontrak',
                'kontrak.nilai_penawaran',
                'penyedia.nama_penyedia',
                'kontrak.npwp_penyedia',
                'kontrak.wakil_sah_penyedia',
                'kontrak.waktu_pelaksanaan',
                'penyedia.kd_penyedia',
                'penyedia.oap'
            );

        if ($request->has('tahun_anggaran') && $request->input('tahun_anggaran') != '') {
            $paket->where('paket.tahun_anggaran', $request->input('tahun_anggaran'));
        }

        if ($request->has('bidang') && $request->input('bidang') != '') {
            $paket->where('paket.bidang', $request->input('bidang'));
        }

        $paket =  $paket->get();

        $vendor = PenyediaModel::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $vendor->where(function ($q) use ($search) {
                $q->where('penyedia.nama_penyedia', 'like', '%' . $search . '%');
            });
        }

        $vendor = $vendor->get();
        $data = [
            'title' => 'Laporan Per Penyedia',
            'paket' => $paket,
            'vendor' => $vendor,
        ];
        return Excel::download(new ExcellLaporanperpenyedia($data), 'laporan_perpenyedia_' . now('Asia/Jayapura')->format('YmdHis') . '.xlsx');
    }
}
