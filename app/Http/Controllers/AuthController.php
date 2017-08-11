<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Hash;
use App\Http\Requests\AuthenticateRequest;
use Validator;

class AuthController extends Controller
{
    public function authenticate(AuthenticateRequest $request) {
      // pela só o email e senha pelo request
      $credentials = $request->only('email', 'password');

      // pega o user/email
      $company = Company::where('email', $credentials['email'])->first();

      // Valida Company
      if(!$company) {
        return response()->json([
          'error' => 'Falha nas credenciais'
        ], 401);
      }

      // Valida Password
      if (!Hash::check($credentials['password'], $company->password)) {
          return response()->json([
            'error' => 'Falha nas credenciais'
          ], 401);
      }

      // Gera Token
      $token = JWTAuth::fromUser($company);

      // Expira Token
      $objectToken = JWTAuth::setToken($token);
      $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');

      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => JWTAuth::decode()->get('exp')
      ]);
    }

    public function authenticate(Request $request) {
      // TODO: authenticate JWT
      $credentials = $request->only('email', 'password');

      $validator = Validator::make($credentials, [
          'password' => 'required',
          'email' => 'required'
      ]);

      if($validator->fails()) {
          return response()->json([
              'message'   => 'Invalid credentials',
              'errors'        => $validator->errors()->all()
          ], 422);
      }
}