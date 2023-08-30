<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function loginGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle() {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $is_user = User::where('email', $user->getEmail())->first();

            if (!$is_user) {
                User::updateOrCreate(
                    [
                        'google_id' => $user->getId()
                    ],
                    [
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'password' => Hash::make($user->getName().'@'. $user->getId()),
                    ]
                );
            } else {
                User::where('email', $user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);

            }
            $saveUser = User::where('email', $user->getEmail())->first();

            Auth::loginUsingId($saveUser->id);

            return redirect()->route('home');


        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
