<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\OtpCode;
use Carbon\Carbon;
use App\Models\Profile;
use App\Mail\RegisterMail;
use App\Mail\GenerateOtpCode;
use Illuminate\Support\Facades\Mail;





class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $roleUser = Roles::where('name','user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleUser->id
        ]);

        Mail::to($user->email)->queue(new RegisterMail($user));

        $user->generateOtpCode();

        $token = JWTAuth::fromUser($user);


        return response()->json([
            "message" => "Register Berhasil",
            "user" => $user,
            "token" => $token
        ]);
    }
    public function getUser() {
        $user = auth()->user();

        $currentUser = User::with(['profile', 'history'])->find($user->id);

        return response()->json([
            "message"=>"berhasil get user",
            "user"=> $currentUser
        ]);
    }

    public function generateOtpCode(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $userData = User::where('email', $request->email)->first();

        Mail::to($userData->email)->queue(new GenerateOtpCode($userData));

        $userData->generateOtpCode();

        return response()->json([
            "message"=> 'Berhasil generate ulang otp code',
            "data"=> $userData

        ]);
        
    }

    public function verifikasi(Request $request){
        $request->validate([
            'otp' => 'required'
        ]);

        // untuk cek otp code sudah ada di table otp dalam database atau belum
        $otp_code = OtpCode::where('otp', $request->otp)->first();

        if(!$otp_code){
            return response()->json([

                "message" => "Otp tidak ditemukan",
            ], 404);
        }
        
        $now = Carbon::now();

        //cek kadaluarsa otp
        if ($now > $otp_code->valid_until){
            return response()->json([

                "message" => "Otp sudah kadaluarsa, silangkan generate ulang",
            ], 404);
        }

        //update user
        $user = User::find($otp_code->user_id);
        $user->email_verified_at = $now;

        $user -> save();

        $otp_code -> delete();

        return response()->json([

            "message" => "Berhasil verifikasi akun",


        ]);
    }


    public function login (Request $request){

        $credentials = request(['email','password']);

        if (!$user = auth()->attempt($credentials)) {
            return response()->json(['message' => 'User invalid'], 401);
        }
    
        $UserData = User::with('role')->where('email', $request['email'])->first();

        $token = JWTAuth::fromUser($UserData);

        return response()->json([

            "user" => $UserData,
            "token" => $token
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(
            [
                'message' => 'Berhasil logout'
            ]);
    }


    public function updateUser(Request $request)
    {

        // Update nama user
        $user = auth()->user();
        
        $user->name = $request['name'];

        
        $user->save();

        // $token = JWTAuth::fromUser($user);

        return response()->json(['message' => 'Username berhasil diupdate'], 200);
    }
        

        
    
};
