<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use GuzzleHttp\Client;
use App\Models\CreatorProfile;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        /** @var AbstractProvider $googleDriver */
        $googleDriver = Socialite::driver('google');

        $googleUser = $googleDriver
            ->stateless()
            ->setHttpClient(new Client(['verify' => false]))
            ->user();

        $user = User::firstOrCreate(
		    ['email' => $googleUser->getEmail()],
		    [
		        'name' => $googleUser->getName(),
		        'password' => bcrypt(Str::random(24)),
		        'role' => 'user',
		    ]
		);

		CreatorProfile::firstOrCreate(
		    ['user_id' => $user->id],
		    [
		        'name' => $user->name,
		        'slug' => Str::slug($user->name) . '-' . $user->id,
		        'type' => 'individual',
		    ]
		);

        Auth::login($user);

        session()->flash('show_welcome_animation', true);

        return redirect()->intended('/dashboard'); 
    }
}