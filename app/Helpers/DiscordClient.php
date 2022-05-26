<?php

namespace App\Helpers;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class DiscordClient
{
    private PendingRequest $client;

    public function __construct (public string $token)
    {
        $this->client = Http::withToken($this->token);
    }

    public function getUserGuildInfo (string $guild_id)
    {
        $response = $this->client->get("https://discord.com/api/users/@me/guilds/{$guild_id}/member");

        return $response->json();
    }

}
