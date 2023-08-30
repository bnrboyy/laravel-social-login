<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function getURL()
    {
        dd(url('/') . '/facebook/callback/');
        return response([
            'data' => __DIR__,
        ]);
    }

    public function loginFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();
            $findUser = User::where('facebook_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect()->intended('home');
            } else {
                $newUser = User::updateOrCreate(
                    ['email' => $user->getEmail()],
                    [
                        'name' => $user->name,
                        'facebook_id' => $user->id,
                        'email' => $user->email,
                        'password' => Hash::make($user->getName() . '@' . $user->getId()),
                    ]
                );

                Auth::login($newUser);
                return redirect()->intended('home');
            }
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),

            ], 500);
        }
    }
}
