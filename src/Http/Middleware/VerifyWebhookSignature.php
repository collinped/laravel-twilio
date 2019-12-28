<?php

namespace Collinped\Twilio\Http\Middleware;

use Closure;
use Twilio\Security\RequestValidator;

class VerifyWebhookSignature
{
    /**
     * Handle an incoming request.
     *
     * @link https://www.twilio.com/docs/usage/security#validating-requests
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(env('APP_ENV') == 'local') {
            return $next($request);
        }

        $token = config('twilio-video.auth_token');
        $signature = $request->header('X-Twilio-Signature');

        $validator = new RequestValidator($token);

        // The Twilio request URL. You may be able to retrieve this from
        $url = $request->fullUrl();

        // The post variables in the Twilio request.
        $postVars = $request->all();

        if (!$validator->validate($signature, $url, $postVars)) {
            return response()->json('Not a valid signature.');
        }

        return $next($request);
    }
}
