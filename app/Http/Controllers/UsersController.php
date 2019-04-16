<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    use \App\Http\Traits\AppResponses;

    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return $this->notFound();
        }
        if (!Hash::check($request->input('password'), $user->hash)) {
            $data['message'] = 'Authentication Failed';
            return $this->badRequest($data);
        }
        $user->update(['token'=>User::getBearerToken($request->input('email'))]);

        return $this->success([
            'user_id' => $user->id,
            'access_token' => $user->token,
            'expires_in' => env('AUTH_EXPIRE'),
            'message' => 'Authenticated successfully',
        ]);
    }
}
