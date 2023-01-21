<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\Admin\AuthResource;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $admin = Admin::where('phone', $request->phone)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->makeToken($admin);
    }
    public function logout(Request $request)
    {
        # code...
    }
    public function admin(Request $request)
    {
        return AuthResource::make($request->user());
    }
    public function makeToken($admin)
    {
        $token = $admin->createToken('admin-token')->plainTextToken;
        return (new AuthResource($admin))
            ->additional(['meta' => [
                'token' => $token,
                'token_type' => 'Bearer',
            ]]);
    }
}
