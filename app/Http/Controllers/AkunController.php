<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Akun;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\InvalidTokenException;
use App\Exceptions\InvalidCredentialException;
use Hash;
use App\Events\TokenRefresh;

class AkunController extends Controller
{
    public function authenticate(Request $request)
    {
        try {
            $user = $this->validateUser($request->get('username'), $request->get('password'));
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();
            
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'Id_Akun' => $user->Id_Akun
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function validateUser($username,$password)
    {
        try{
            $user = Akun::where('Username',$username)->firstOrFail();
            if (!password_verify($password, $user->Password)) {
                throw new InvalidCredentialException();
            }

            return $user;
        } catch(ModelNotFoundException $e) {
            throw $e;
            // return $this->sendIseResponse($e->getMessage());
        }
    }
    
    // public function logout(Request $request){
    //     dd($request);
    //     $request->user()->token()->delete(); 
    //     return response()->json([
    //         'message' => 'Successfully logged out'
    //     ]);
    // }
}