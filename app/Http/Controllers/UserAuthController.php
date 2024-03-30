<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class UserAuthController extends Controller
{

    public function createAuthenticationToken(Request $request, $id) {
        $user = User::find($id);
        $token = $user->createToken('CBSC')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    // login to user
    public function login(Request $request)
    {
        $all = $request->all();
        $validator = Validator::make($all, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $user = User::where('email', $all['email'])->first();

        if (!$user || !password_verify($all['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('CBSC')->plainTextToken;
        $user->load('managing');
        $user->load('invitations');
        $user->load('licensed');

        return response()->json(['user' => $user, 'token' => $token]);
    }

    // logout user
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
