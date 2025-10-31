<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (($user->role == 'Admin')) {
            $data = [
                'title' => 'Dashboard',
                'active' => 'dashboard',
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
