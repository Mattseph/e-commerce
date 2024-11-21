<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function authProviderRedirect(string $provider)
    {
        if ($provider) {

            return Socialite::driver($provider)->redirect();
        }

        return abort(404);
    }

    public function socialAuth(string $provider)
    {
        if ($provider) {
            try {
                $socialUser = Socialite::driver($provider)->user();
                $user = User::where('auth_provider_id', $socialUser->id)->first();

                if ($user) {
                    Auth::login($user, true);
                } else {
                    $newUser = User::create([
                        'name' => $socialUser->name,
                        'email' => $socialUser->email,
                        'auth_provider' => $provider,
                        'auth_provider_id' => $socialUser->id,
                        'password' => Hash::make('Password'),
                    ]);

                    Auth::login($newUser, true);
                }

                return to_route('user.index');
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }
}
