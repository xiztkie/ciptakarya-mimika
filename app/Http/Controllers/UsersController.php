<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $users = $query->orderBy('created_at', 'desc')->paginate(5);
        $data = [
            'title' => 'User Data',
            'active' => 'settings-users',
            'users' => $users,
            'search' => $request->input('search'),
        ];
        return view('admin.users-data', $data);
    }

    public function adduser(Request $request)
    {
        $auth = auth()->user()->role;

        if ($auth !== 'Admin') {
            return redirect()->back()->with('toast_error', 'Anda tidak memiliki izin untuk menambahkan user.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:Admin,User',
            'contact' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'avatar.image' => 'Avatar harus berupa gambar.',
            'avatar.mimes' => 'Avatar harus berformat jpeg, png, jpg, atau gif.',
            'avatar.max' => 'Ukuran avatar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast_error', 'Periksa kembali input Anda.');
        }

        try {
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $fileName = time() . '_' . $request->file('avatar')->getClientOriginalName();
                $avatarPath = $request->file('avatar')->storeAs('avatars', $fileName, 'public');
            }

            UsersModel::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'contact' => $request->contact,
                'avatar' => $avatarPath,
            ]);

            return redirect()->back()->with('toast_success', 'User berhasil ditambahkan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }

    public function edituser(Request $request, $id)
    {
        $auth = Auth::user()->role;

        if ($auth !== 'Admin') {
            return redirect()->back()->with('toast_error', 'Anda tidak memiliki izin untuk mengubah data user.');
        }

        $ids = decrypt($id);
        $user = UsersModel::findOrFail($ids);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'avatar.image' => 'Avatar harus berupa gambar.',
            'avatar.mimes' => 'Avatar harus berformat jpeg, png, jpg, atau gif.',
            'avatar.max' => 'Ukuran avatar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast_error', 'Periksa kembali input Anda.');
        }

        try {
            $avatarPath = $user->avatar;
            if ($request->hasFile('avatar')) {
                $fileName = time() . '_' . $request->file('avatar')->getClientOriginalName();
                $avatarPath = $request->file('avatar')->storeAs('avatars', $fileName, 'public');

                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'avatar' => $avatarPath,
            ]);

            return redirect()->back()->with('toast_success', 'User berhasil diperbarui.');
        } catch (\Illuminate\Database\QueryException) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        } catch (\Exception) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }

    public function updatepassword(Request $request, $id)
    {
        $auth = auth()->user()->role;

        if ($auth !== 'Admin') {
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

    public function deleteuser($id)
    {
        $auth = auth()->user()->role;

        if ($auth !== 'Admin') {
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

    public function profile()
    {
        $user = Auth::user();

        $data = [
            'title' => 'User Profile',
            'active' => 'user-profile',
            'user' => $user,
        ];

        return view('admin.user-profile', $data);
    }

    public function updateprofile(Request $request, $id)
    {
        $ids = decrypt($id);
        $user = User::findOrFail($ids);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
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
                'contact' => $request->contact,
            ]);

            return redirect()->back()->with('toast_success', 'Profil berhasil diperbarui.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }

    public function changepassword(Request $request, $id)
    {
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

            return redirect()->back()->with('toast_success', 'Password berhasil diperbarui.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat memperbarui password. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }

    public function updateavatar(Request $request)
    {
        $ids = Auth::id();
        $user = UsersModel::findOrFail($ids);

        $validator = Validator::make($request->all(), [
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast_error', 'Periksa kembali input Anda.');
        }

        try {
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->update([
                    'avatar' => $avatarPath,
                ]);
            }

            return redirect()->back()->with('toast_success', 'Avatar berhasil diperbarui.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan saat memperbarui avatar. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan tak terduga. Silakan coba lagi.');
        }
    }
}
