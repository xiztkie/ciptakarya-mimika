<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        $data = [
            'title' => 'User Data',
            'active' => 'settings-users',
            'users' => $users,
            'search' => $request->input('search'),
        ];
        return view('admin.users-data', $data);
    }

    public function create(Request $request)
    {
        $auth = auth()->user()->role;

        if ($auth !== 'admin') {
            return redirect()->back()->with('toast_error', 'Anda tidak memiliki izin untuk menambahkan user.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,user',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast_error', 'Periksa kembali input Anda.');
        }

        try {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);

            return redirect()->back()->with('toast_success', 'User berhasil ditambahkan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }

    public function update(Request $request, $id)
    {
        $auth = auth()->user()->role;

        if ($auth !== 'admin') {
            return redirect()->back()->with('toast_error', 'Anda tidak memiliki izin untuk mengubah user.');
        }

        $ids = decrypt($id);
        $user = User::findOrFail($ids);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,Operator',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast_error', 'Periksa kembali input Anda.');
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            return redirect()->back()->with('toast_success', 'User berhasil diperbarui.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }

    public function updatepassword(Request $request, $id)
    {
        $auth = auth()->user()->role;

        if ($auth !== 'admin') {
            return redirect()->back()->with('toast_error', 'Anda tidak memiliki izin untuk mengubah password user.');
        }

        $ids = decrypt($id);
        $user = User::findOrFail($ids);

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast_error', 'Periksa kembali input Anda.');
        }

        try {
            $user->update([
                'password' => bcrypt($request->password),
            ]);

            return redirect()->back()->with('toast_success', 'Password user berhasil diperbarui.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat memperbarui password. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }

    public function delete($id)
    {
        $auth = auth()->user()->role;

        if ($auth !== 'admin') {
            return redirect()->back()->with('toast_error', 'Anda tidak memiliki izin untuk menghapus user.');
        }

        $ids = decrypt($id);
        $user = User::findOrFail($ids);

        try {
            $user->delete();
            return redirect()->back()->with('toast_success', 'User berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }
}
