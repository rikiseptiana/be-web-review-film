<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:api', 'isAdmin'])->only('store','update','destroy');
    }

    public function dashboard () {
        $limitMovie = Movie::orderBy('year')->take(2)->get();
        return response()->json([
            "message" => "tampil limit 2 data movie terbaru",
            "data" => $limitMovie
        ], 200);
    }
    public function index()
    {
        $movie = Movie::all();

        return response()->json([
            "message" => 'tampilkan semua Movie',
            "data" => $movie
            
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    {
        $data = $request->validated();

       // jika file gambar diinput

        if ($request->hasFile('poster')) {

             // membuat unique name pada gamabr yang di input

             $posterName = time()."-image.".$request->poster->extension();

             // simpan gambar pada file storage

             $request->poster->storeAs('public/poster', $posterName);

             // menganti request nilai request image menjadi $imageName yang baru bukan berdasarkan request

             $path = env('APP_URL').'/storage/poster/';
            
             $data['poster'] = $path.$posterName; 
        }
        
        Movie::create($data);

        return response()->json([
            "message" => "Tambah movie berhasil"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::with('genre', 'listReview') -> find($id);

        if (!$movie) {
            return response()->json([
                    "message" => " id Movie tidak ditemukan"
            ], 404);
        } 
        return response()->json([
            "message" => "data dengan id : $id",
            "data" => $movie
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, MovieRequest $request){
        $data = $request->validated();

        $movieData = Movie::find($id);

        if (!$movieData) {
            return response()->json([
                    "message" => "Movie id tidak ditemukan"
            ], 404);
        } 

        if ($request->hasFile('poster')) {

            // Hapus gambar lama jika ada

            if ($movieData->poster) {
                $namePoster = basename($movieData->poster);
                Storage::delete('public/poster/' . $namePoster);

                //return response()->json($data);
            }

    
            // membuat unique name pada gamabr yang di input

            $posterName = time()."-image.".$request->poster->extension();

            // simpan gambar pada file storage

            $request->poster->storeAs('public/poster', $posterName);

            // menganti request nilai request image menjadi $imageName yang baru bukan berdasarkan request

            $path = env('APP_URL').'/storage/poster/';
           
            $data['poster'] = $path.$posterName;

        }

        $movieData->update($data);

        return response()->json([
            "message" => "Data Movie berhasil di update"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movieData = Movie::find($id);

        if (!$movieData) {
            return response()->json([
                    "message" => " Movie id tidak ditemukan"
            ], 404);
        }

        if ($movieData->poster) {
            $namePoster = basename($movieData->poster);
            Storage::delete('public/poster/' . $namePoster);

        $movieData->delete();

        return response()->json([
                    "message" => "data dengan id : $id telah berhasil dihapus"
         ], 200);
        }
    }
}
