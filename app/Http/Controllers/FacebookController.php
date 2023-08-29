<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function getURL() {
        dd(url('/') . '/facebook/callback/');
        return response([
            'data' => __DIR__,
        ]);
    }

    public function loginFacebook() {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook() {
        try {
            $user = Socialite::driver('facebook')->user();
            dd($user);

        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),

            ], 500);
        }
    }
}
