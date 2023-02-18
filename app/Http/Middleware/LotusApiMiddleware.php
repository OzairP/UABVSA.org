<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LotusApiMiddleware
{
    public const REQUIRE_BASIC_AUTH_HEADER = [
        'WWW-Authenticate' => 'Basic realm="User Visible Realm", charset="UTF-8"'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isSecure()) {
            Log::info('Insecure request through lotus api middleware.');
            throw new BadRequestHttpException('This endpoint requires HTTPS.');
        }

        $secret = nova_get_setting('lotus_scanner_passkey');

        if ($secret === null) {
            Log::error('Lotus scanner passkey is not set.');
            throw new HttpException(500);
        }

        $digest = base64_encode($secret . ":" . $secret);
        if ($request->header('Authorization') !== "Basic {$digest}") {
            throw new HttpException(401, 'Invalid credentials', headers: self::REQUIRE_BASIC_AUTH_HEADER);
        }

        return $next($request);
    }
}
