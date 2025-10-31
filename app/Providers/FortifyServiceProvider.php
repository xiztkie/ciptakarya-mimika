<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        Fortify::authenticateUsing(function (Request $request) {
            $request->validate([
                'login' => ['required', 'string'],
                'password' => ['required', 'string'],
                'captcha' => ['required', 'captcha'],
            ]);

            $userEmail = $request->login;
            $userPassword = $request->password;

            $user = User::where('email', $userEmail)
                ->orWhere('username', $userEmail)
                ->first();

            if ($user && Hash::check($userPassword, $user->password)) {
                return $user;
            }

            return false;
        });

        Fortify::loginView(function () {
            return view('login');
        });
    }
}
