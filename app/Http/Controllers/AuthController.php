<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\DiscordClient;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    /**
     * Redirects to the discord OAuth 2.0 login
     *
     * @return mixed
     */
    public function discord_redirect ()
    {
        return Socialite::driver('discord')
                        ->scopes(['identify', 'email', 'guilds', 'guilds.members.read'])
                        ->redirect();
    }

    /**
     * Callback from discord OAuth 2.0 login
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function discord_callback ()
    {
        $discord_user = Socialite::driver('discord')->stateless()->user();
        $client = new DiscordClient($discord_user->token);

        $membership = $client->getUserGuildInfo(config('discord.guild_id'));

        $user = User::updateOrCreate([
            'discord_id' => $discord_user->getId(),
        ], [
            'nickname' => $discord_user->getNickname(),
            'email' => $discord_user->getEmail(),
            'discord_id' => $discord_user->getId(),
            'avatar' => $discord_user->getAvatar(),
            'roles' => $membership['roles'],
            'access_token' => $discord_user->token,
            'refresh_token' => $discord_user->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/');
    }

}
