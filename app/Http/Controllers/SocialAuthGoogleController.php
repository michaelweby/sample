<?php

namespace App\Http\Controllers;

use App\Services\SocialGoogleAccountService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;


class SocialAuthGoogleController extends Controller
{
    public function redirect()
    {

        return Socialite::driver('google')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialGoogleAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('google')->scopes(['name', 'first_name', 'last_name', 'email', 'gender', 'verified'])->user());
        auth()->login($user);
        return redirect()->to('/');
    }
}
