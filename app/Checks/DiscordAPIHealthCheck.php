<?php

namespace App\Checks;

use Illuminate\Support\Facades\Http;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class DiscordAPIHealthCheck extends Check
{

    protected ?string $label = 'Discord API';

    public function run (): Result
    {
        $result = Result::make();
        $summary = $this->getDiscordApiHealthSummary();
        $status = $summary['status'];

        $result->shortSummary(ucfirst($status));
        $result->meta($summary);

        return match ($status) {
            'operational' => $result->ok(),
            'degraded' => $result->warning(),
            default => $result->failed($status),
        };
    }

    public function getDiscordApiHealthSummary (): array
    {
        $response = collect(Http::get('https://discordstatus.com/api/v2/summary.json')
                                ->json()['components']);

        return $response->firstWhere('name', 'API');
    }
}
