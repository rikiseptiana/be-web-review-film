<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;


class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'movie_id' => 'required|exists:movie,id',
            'critic' => 'required|string',
            'rating' => 'required|integer',
            //'user_id' => 'required|exists:user,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $currentUser = auth()->user();

        // $review = Review::find($currentUser->id);

        $review = Review::updateOrCreate(
            ['user_id'=> $currentUser->id],
            [
                'movie_id' => $request['movie_id'],
                'critic' => $request['critic'],
                'rating' => $request['rating'],
                'user_id' => $currentUser->id,
            ]
            );

            return response()->json([
                "message" => 'Tambah or Update Review Film',
                "data" => $review
                
            ], 201);
    }
}
