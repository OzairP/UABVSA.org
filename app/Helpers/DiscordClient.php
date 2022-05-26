<?php

namespace App\Helpers;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

enum DiscordRole: string
{
    case PRESIDENT = '633743719635615744';
    case VICE_PRESIDENT = '633743904214220811';
    case EBOARD = '633131156719796228';
    case HELPER = '633754951771750420';
    case ALUMNI = '801684857653952544';
    case MEMBER = '633131484177367049';
}

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
