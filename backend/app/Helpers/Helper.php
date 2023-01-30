<?php

namespace App\Helpers;

use Twilio\Rest\Client;


function send_ms($msg, $status, $code)
{
    return response()->json([
        'message' => $msg,
        'status' => $status,
    ], $code);
}
if (!function_exists('twilio_env')) {
    function twilio_env()
    {
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $verificationSid = getenv("TWILIO_VERIFICATION_SID");
        $twilio = new Client($sid, $token);
        $verification = $twilio->verify->v2->services($verificationSid);
        return $verification;
    }
}
