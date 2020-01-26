<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Enums\Gender;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'email'=>'required|email|unique:tbl_user',
            'nama'=>'required',
            'gender'=> 'required|in:MEN,WOMEN',
            'password'=>'required|min:8'
        ]);
        // var_dump(new EnumValue(Gender::class)); die();

        $user = new User([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if ($user->save()) {
            $response = response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data Created',
                    'data' => $user
                ]
            )
            ->setStatusCode(Response::HTTP_CREATED);
        } else {
            $response = response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed'
                ]
            )
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        return $response->header('Accept', 'application/json');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $request->email)->first();
        $plainPassword = $request->password;
        $hashedPassword = $user->password;
        if (!$user) {
            $response = response()->json(
                [
                    'status' => 'error',
                    'message' => 'Email Does not Exist'
                ]
            )
            ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        // Check Hash Password
        if (Hash::check($plainPassword, $hashedPassword)) {
            $response = response()->json(
                [
                    'status' => 'success',
                    'message' => 'Login Successfully',
                    'data' => $user
                ]
            )
            ->setStatusCode(Response::HTTP_OK);
        } else {
            $response = response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Email or Password incorrect'
                ]
            )
            ->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        return $response->header('Accept', 'application/json');
    }
}
