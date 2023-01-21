<?php

namespace App\Http\Controllers\Api\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Seller\LoginRequest;
use App\Http\Resources\Seller\AuthResource;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $seller = Seller::where('phone', $request->phone)->first();

        if (!$seller || !Hash::check($request->password, $seller->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->makeToken($seller);
    }
    public function logout(Request $request)
    {
        # code...
    }
    public function seller(Request $request)
    {
        return AuthResource::make($request->user());
    }
    public function makeToken($seller)
    {
        $token = $seller->createToken('seller-token')->plainTextToken;
        return (new AuthResource($seller))
            ->additional(['meta' => [
                'token' => $token,
                'token_type' => 'Bearer',
            ]]);
    }
}
