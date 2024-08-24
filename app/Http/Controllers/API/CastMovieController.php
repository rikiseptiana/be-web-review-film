<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CastMovie;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CastMovieRequest;


class CastMovieController extends Controller
{
    public function __construct(){

    $this->middleware(['auth:api', 'isAdmin'])->only('store','update','destroy');
    }

    public function index() {
        $castMovie = CastMovie::all();

        return response()->json([
            "message" => 'Berhasil tampilkan cast movie',
            "data" => $castMovie
            
        ], 200
        );
    }

    public function store(CastMovieRequest $request)
    {
        CastMovie::create($request->all());

        return response()->json([
            "message" => "Berhasil tambah cast movie"
        ],201);
    }

    public function show(string $id){

        $idCastMovie = CastMovie::with('Cast', 'Movie')->find($id);

        if (!$idCastMovie) {
            return response()->json([
                    "message" => "id tidak ditemukan"
            ], 404);
        } 
        return response()->json([
            "message" => "data dengan id : $id",
            "data" => $idCastMovie
        ]);

    }

    public function update(CastMovieRequest $request, string $id)
    {
        $idCastMovie = CastMovie::find($id);

        if (!$idCastMovie) {
            return response()->json([
                    "message" => "id tidak ditemukan"
            ], 404);
        }

        $idCastMovie->name = $request['name'];
        $idCastMovie->cast_id = $request['cast_id'];
        $idCastMovie->movie_id = $request['movie_id'];
        $idCastMovie->save();

        return response()->json([
            "message" => "Berhasil melakukan update id: $id",
            "data :" => $idCastMovie
        ],201);

    }
    public function destroy(string $id)
    {
        $castMovie = CastMovie::find($id);

        if (!$castMovie) {
            return response()->json([
                    "message" => "id tidak ditemukan"
            ], 404);
        }

        $castMovie->delete();
        return response()->json([
                    "message" => "data dengan id : $id telah berhasil dihapus"
         ]);
    }

}
