<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiModel;
use App\Models\PaketModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DokumentasiController extends Controller
{
    public function adddokumentasi($id, Request $request)
    {
        $ids = decrypt($id);
        $paket = PaketModel::where('id', $ids)->first();
        $validated = $request->validate([
            'files'    => 'required|array',
            'files.*'  => 'file|mimes:jpg,jpeg,png,bmp|max:2048',
        ], [
            'files.required'    => 'File dokumentasi wajib diunggah.',
            'files.array'       => 'File dokumentasi harus berupa array.',
            'files.*.file'      => 'Setiap item dalam file harus berupa file.',
            'files.*.mimes'     => 'File harus memiliki format jpg, jpeg, png, atau bmp.',
            'files.*.max'       => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->file('files') as $file) {
                $name = Str::uuid() . '_' . $paket->kd_rup;
                $filename = $name . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("dokumentasi/{$ids}", $filename, 'public');

                DokumentasiModel::create([
                    'paket_id' => $ids,
                    'file_path' => "storage/{$path}",
                ]);
            }

            DB::commit();
            return back()->with('success', 'Dokumentasi berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors('Upload gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function deletedokumentasi($id)
    {
        try {
            $ids = decrypt($id);
            $dokumentasi = DokumentasiModel::findOrFail($ids);
            $filePath = preg_replace('/^storage\//', '', $dokumentasi->file_path);

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $dokumentasi->delete();
            Log::info("Dokumen dengan ID: {$ids} berhasil dihapus.");

            return back()->with('success', 'Dokumentasi berhasil dihapus.');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'ID dokumen tidak valid.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus dokumentasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus dokumentasi.');
        }
    }
}
