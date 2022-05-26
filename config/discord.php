<?php

enum DiscordRole: string
{
    case PRESIDENT = '633743719635615744';
    case VICE_PRESIDENT = '633743904214220811';
    case EBOARD = '633131156719796228';
    case HELPER = '633754951771750420';
    case ALUMNI = '801684857653952544';
    case MEMBER = '633131484177367049';
}

return [

    'guild_id' => env('DISCORD_GUILD_ID', '632789687530029118'),

    'roles' => [
        'president' => DiscordRole::PRESIDENT,
        'vice_president' => DiscordRole::VICE_PRESIDENT,
        'eboard' => DiscordRole::EBOARD,
        'helper' => DiscordRole::HELPER,
        'alumni' => DiscordRole::ALUMNI,
        'member' => DiscordRole::MEMBER
    ]

];
