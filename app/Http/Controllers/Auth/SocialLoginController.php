<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SocialLoginController extends Controller
{
    /**
     * Redirect to Google's OAuth 2.0 service.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Ensure we have email and default the name if missing
            $name = $googleUser->getName() ?? 'Google User'; // Fallback to 'Google User'
            $email = $googleUser->getEmail();

            if (!$email) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Failed to retrieve your email address from Google.',
                ]);
            }

            // Find or create the user
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => bcrypt(str()->random(16)), // Generate a random password
                ]
            );

            // Log in the user
            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'An error occurred during Google login. Please try again.',
            ]);
        }
    }
}
