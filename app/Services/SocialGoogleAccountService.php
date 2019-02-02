<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 8/17/2018
 * Time: 11:05 PM
 */

namespace App\Services;
use App\SocialAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialGoogleAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('google')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'google'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'first_name' => $providerUser->getName(),
                    'username'=>str_slug($providerUser->getName().rand(111,999)),
                    'type'=>'customer',
                    'password' => md5(rand(1,10000)),
                    'image'=>$providerUser->getAvatar(),

                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}