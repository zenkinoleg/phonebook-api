<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UsersController extends Controller
{
    use ResponseHelpers;

	public function login(Request $request) {
		$user = User::where('email',$request->input('email'))->first();
		if ( !$user ) {
			return $this->not_found();
		}
		if ( !Hash::check($request->input('password'),$user->hash)) {
			$data['message'] = 'Authentication Failed';
			return $this->bad_request($data);
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
