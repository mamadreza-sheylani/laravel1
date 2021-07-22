<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider($provider){

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider){


        try {
            $socialite_user = Socialite::driver($provider)->user();

        } catch (\Exception $ex) {


            alert()->error(null , 'something went wrong');
            return redirect()->route('login');
        }

        $user_exist = User::where('email' , $socialite_user->getEmail())->first();
        if (!$user_exist) {
            $user = User::create([
                'name' => $socialite_user->getName(),
                'provider_name' => $provider,
                'avatar' => $socialite_user->getAvatar(),
                'email' => $socialite_user->getEmail(),
                'password' => Hash::make($socialite_user->getId()),
                'email_verified_at' => Carbon::now(),


            ]);
        }

        auth()->login($user_exist , $remember=True);
        alert()->success(null , 'ورود با موفقیت انجام شد')->persistent('باشه');
        return redirect()->back();
    }
}
