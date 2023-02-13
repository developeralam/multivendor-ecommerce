<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers;
use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function App\Helpers\send_ms;
use function App\Helpers\twilio_env;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User\AuthResource;
use App\Http\Requests\User\RegisterRequest;

use App\Http\Requests\User\OtpVerifyRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->makeToken($user);
    }
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());
            $data = twilio_env();
            $res = $data->verifications
                ->create("+88" . $user->phone, "sms");

            return send_ms('Otp Send Successfully', true, 200);
        } catch (\Throwable $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }
    public function resendOtp(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->first();
            $data = twilio_env();
            $res = $data->verifications
                ->create("+88" . $user->phone, "sms");

            return send_ms('Otp Send Successfully', true, 200);
        } catch (\Throwable $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }

    public function verifyOtp(OtpVerifyRequest $request)
    {
        try {
            $data = twilio_env();
            $res = $data->verificationChecks
                ->create(
                    [
                        "to" => "+88" . $request->phone,
                        "code" => $request->otp
                    ]
                );
            if ($res->status === 'approved') {
                $user = User::where('phone', $request->phone)->first();
                $user->update([
                    'isVarified' => 1,
                ]);
                return $this->makeToken($user);
            }
        } catch (\Throwable $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout Successfully',
            'status' => 200,
        ], 200);
    }
    public function user(Request $request)
    {
        return AuthResource::make($request->user());
    }
    public function makeToken($user)
    {
        $wishlist = $user->wishlistPorducts()->get();
        $token = $user->createToken('user-token')->plainTextToken;
        return (new AuthResource($user))
            ->additional(['meta' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'wishlists' => $wishlist
            ]]);
    }
}
