<?php

namespace App\Http\Controllers;

use App\Models\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;

class SocialLogin extends Controller
{
    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook(SocialAccountService $service)
    {
        try {
            $fb_user = Socialite::driver('facebook')->user();
            $user = $service->createOrGetFBUser($fb_user);
            if (! $user) {
                return redirect(route('facebook_redirect'));
            }
            auth()->login($user);

            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }

    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(SocialAccountService $service)
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = $service->createOrGetGoogleUser($google_user);
            if (! $user) {
                return redirect(route('google_redirect'));
            }
            auth()->login($user);

            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            //return $e->getMessage();
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }

    public function redirectTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function callbackTwitter(SocialAccountService $service)
    {
        try {
            $twitter_user = Socialite::driver('twitter')->user();
            $user = $service->createOrGetTwitterUser($twitter_user);
            if (! $user) {
                return redirect(route('twitter_redirect'));
            }
            auth()->login($user);

            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            //return $e->getMessage();
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }
}
