<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialAuth;
use App\Models\User;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return \Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $user = \Socialite::driver($provider)->user();

        $account = SocialAuth::where([
            'provider' => $provider,
            'social_id' => $user->id
        ])->first();

        if ($account) {
            auth()->login($account->user);
            return redirect()->to('/');
        }

        $localUser = User::where('email', $user->email)->first();

        if ($localUser) {
            return redirect()->to('/');
        }

        $newUser = new User;
        $newUser->name = $user->name;
        $newUser->email = $user->email;
        $newUser->password = md5(rand(1,1000));
        $newUser->save();

        $account = new SocialAuth;
        $account->provider = $provider;
        $account->social_id = $user->id;
        $account->user_id = $newUser->id;
        $account->save();

        auth()->login($newUser);

        redirect()->to('/');
    }
}
