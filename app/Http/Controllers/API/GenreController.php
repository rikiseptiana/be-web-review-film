<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Http\Requests\GenreRequest;
class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->middleware(['auth:api', 'isAdmin'])->only('store','update','destroy');
    }
    
    public function index()
    {
        $genre = Genre::all();

        return response()->json([
            "message" => 'tampilkan semua genre',
            "data" => $genre
            
        ], 200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenreRequest $request)
    {
        Genre::create($request->all());

        return response()->json([
            "message" => "Berhasil tambah Genre"
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::with("listMovie")->find($id);

        if (!$genre) {
            return response()->json([
                    "message" => "id tidak ditemukan"
            ], 404);
        } 
        return response()->json([
            "message" => "data dengan id : $id",
            "data" => $genre
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenreRequest $request, string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                    "message" => "id tidak ditemukan"
            ], 404);
        }

        $genre->name = $request['name'];

        $genre->save();

        return response()->json([
            "message" => "Berhasil melakukan update id: $id"
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                    "message" => "id tidak ditemukan"
            ], 404);
        }

        $genre->delete();

        return response()->json([
                    "message" => "data dengan id : $id telah berhasil dihapus"
         ]);
    }
}
