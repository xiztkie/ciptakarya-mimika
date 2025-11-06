<?php

namespace App\Http\Controllers;

use App\Models\BidangModel;
use App\Models\KontrakModel;
use App\Models\PaketModel;
use App\Models\PenyediaModel;
use Illuminate\Http\Request;

class MasterdataController extends Controller
{
    public function datapaket(Request $request)
    {
        $query = PaketModel::query()
            ->leftJoin('kontrak', 'paket.kd_rup', '=', 'kontrak.kd_rup')
            ->leftJoin('penyedia', 'kontrak.npwp_penyedia', '=', 'penyedia.npwp_penyedia')
            ->where('paket.kd_satker_str', "1.03.0.00.0.00.01.0000")
            ->where(function ($q) {
                $q->where(function ($subQ) {
                    $subQ->where('paket.status_nontender', '!=', 'Gagal/Batal');
                })->orWhere(function ($subQ) {
                    $subQ->where('paket.status_tender', '!=', 'Gagal/Batal');
                });
            })
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

        if ($request->has('bidang') && $request->input('bidang') != '') {
            $bidang = $request->input('bidang');
            $query->where('paket.bidang', $bidang);
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('paket.nama_paket', 'like', '%' . $search . '%')
                    ->orWhere('paket.kd_rup', 'like', '%' . $search . '%')
                    ->orWhere('penyedia.nama_penyedia', 'like', '%' . $search . '%');
            });
        }

        $data = [
            'title' => 'Data Paket',
            'paket' => $query->paginate(8),
            'bidang' => BidangModel::all(),
            'penyedia' => PenyediaModel::all(),
        ];

        return view('admin.datapaket', $data);
    }

    public function editpaket($id, Request $request)
    {
        $ids = decrypt($id);
        $request->validate([
            'sumber_dana' => 'nullable|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'nilai_kontrak' => 'nullable|string',
            'nilai_penawaran' => 'nullable|string',
            'nama_penyedia' => 'nullable|string|max:255',
            'npwp_penyedia' => 'nullable|string|max:20',
            'wakil_sah_penyedia' => 'nullable|string|max:255',
            'waktu_pelaksanaan' => 'nullable|string',
        ]);

        $paket = PaketModel::findOrFail($ids);
        $paket->update([
            'sumber_dana' => $request->input('sumber_dana'),
            'bidang' => $request->input('bidang'),
        ]);

        $kdTender = $paket->kd_tender ?? $paket->kd_nontender;

        if ($kdTender) {
            $kontrak = KontrakModel::where('kd_tender', $kdTender)
                ->orWhere('kd_nontender', $kdTender)
                ->first();

            if ($kontrak) {
                $kontrak->update([
                    'nilai_kontrak' => str_replace('.', '', $request->input('nilai_kontrak')),
                    'nilai_penawaran' => str_replace('.', '', $request->input('nilai_penawaran')),
                    'nama_penyedia' => $request->input('nama_penyedia'),
                    'npwp_penyedia' => $request->input('npwp_penyedia'),
                    'wakil_sah_penyedia' => $request->input('wakil_sah_penyedia'),
                    'waktu_pelaksanaan' => $request->input('waktu_pelaksanaan'),
                ]);
            } else {
                KontrakModel::create([
                    'kd_rup' => $paket->kd_rup,
                    'kd_tender' => $paket->kd_tender,
                    'kd_nontender' => $paket->kd_nontender,
                    'nilai_kontrak' => str_replace('.', '', $request->input('nilai_kontrak')),
                    'nilai_penawaran' => str_replace('.', '', $request->input('nilai_penawaran')),
                    'nama_penyedia' => $request->input('nama_penyedia'),
                    'npwp_penyedia' => $request->input('npwp_penyedia'),
                    'wakil_sah_penyedia' => $request->input('wakil_sah_penyedia'),
                    'waktu_pelaksanaan' => $request->input('waktu_pelaksanaan'),
                ]);
            }

            if ($request->input('npwp_penyedia')) {
                $penyedia = PenyediaModel::where('npwp_penyedia', $request->input('npwp_penyedia'))->first();

                if (!$penyedia) {
                    PenyediaModel::create([
                        'npwp_penyedia' => $request->input('npwp_penyedia'),
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Data paket berhasil diupdate.');
    }

    /* BIDANG */
    public function bidang(Request $request)
    {
        $query = BidangModel::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_bidang', 'like', '%' . $search . '%');
        }
        $data = [
            'title' => 'Data Bidang',
            'bidang' => $query->paginate(10),
        ];

        return view('admin.bidang', $data);
    }

    public function addbidang(Request $request)
    {
        $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:bidang,nama_bidang',
        ]);

        $request->merge([
            'nama_bidang' => strtoupper($request->input('nama_bidang'))
        ]);

        BidangModel::create([
            'nama_bidang' => $request->input('nama_bidang'),
        ]);

        return redirect()->back()->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function editbidang($id, Request $request)
    {
        $ids = decrypt($id);
        $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:bidang,nama_bidang,' . $ids,
        ]);

        $request->merge([
            'nama_bidang' => strtoupper($request->input('nama_bidang'))
        ]);

        $bidang = BidangModel::findOrFail($ids);
        $bidang->update([
            'nama_bidang' => $request->input('nama_bidang'),
        ]);

        return redirect()->back()->with('success', 'Bidang berhasil diupdate.');
    }

    public function deletebidang($id)
    {
        $ids = decrypt($id);
        $bidang = BidangModel::findOrFail($ids);
        $bidang->delete();

        return redirect()->back()->with('success', 'Bidang berhasil dihapus.');
    }

    /* PENYEDIA */
    public function datapenyedia(Request $request)
    {
        $query = PenyediaModel::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_penyedia', 'like', '%' . $search . '%')
                    ->orWhere('npwp_penyedia', 'like', '%' . $search . '%')
                    ->orWhere('kd_penyedia', 'like', '%' . $search . '%');
            });
        }

        $data = [
            'title' => 'Data Penyedia',
            'penyedia' => $query->paginate(10),
        ];

        return view('admin.datapenyedia', $data);
    }

    public function editpenyedia($id, Request $request)
    {
        $ids = decrypt($id);
        $request->validate([
            'nama_penyedia' => 'nullable|string|max:255',
            'npwp_penyedia' => 'nullable|string|max:20',
            'bentuk_usaha' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:500',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kodepos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|string|max:100',
            'nomor_pkp' => 'nullable|string|max:50',
            'status_npwp' => 'nullable|string|max:50',
            'status_kswp' => 'nullable|string|max:50',
            'status_pelaku_usaha' => 'nullable|string|max:100',
            'alamat_pusat' => 'nullable|string|max:500',
            'telepon_pusat' => 'nullable|string|max:50',
            'fax_pusat' => 'nullable|string|max:50',
            'email_pusat' => 'nullable|email|max:100',
            'setuju_publikasi_data' => 'nullable|boolean',
            'oap' => 'nullable|boolean',
        ]);

        $penyedia = PenyediaModel::findOrFail($ids);
        $penyedia->update($request->all());

        return redirect()->back()->with('success', 'Data penyedia berhasil diupdate.');
    }
}
