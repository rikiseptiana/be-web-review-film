<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'age' => 'required|integer',
            'address' => 'required|string',
            'bio' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $currentUser = auth()->user();

        // $user = User::find($currentUser->id);

        $profileData = Profile::updateOrCreate(
            ['user_id'=> $currentUser->id],
            [
                'age' => $request['age'],
                'address' => $request['address'],
                'bio' => $request['bio'],
                'user_id' => $currentUser->id,
            ]
            );

            return response()->json([
                "message" => 'Tambah/Update profile User',
                "data" => $profileData
                
            ], 201);
    }

    public function index()
    {
        $currentUser = auth()->user();
        $profile = Profile::with('user')->where('user_id', $currentUser->id)->first();

        return response()->json([
            "message" => 'Menampilkan data profile',
            "data" => $profile
            
        ], 200
        );
    }
}