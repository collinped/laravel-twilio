<?php

namespace Collinped\Twilio\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Twilio\Security\RequestValidator;

class TwilioRequestValidator
{
    /**
     * Handle an incoming request.
     *
     * @link https://www.twilio.com/docs/usage/security#validating-requests
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (env('APP_ENV') === 'testing') {
            return $next($request);
        }

        $token = config('twilio.auth_token');
        $validator = new RequestValidator($token);

        if (! $validator->validate(
            $request->header('X-Twilio-Signature'),
            $request->fullUrl(),
            $request->toArray()
        )) {
            return response()->json('Not a valid signature.', 403);
        }

        return $next($request);
    }
}
