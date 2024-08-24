<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class CastMovie extends Model
{
    use HasFactory, HasUuids;

    protected $table="cast_movie";
    protected $fillable = [
        'name',
        'cast_id',
        'movie_id'
    ];

    public function Cast(){
        return $this->belongsTo(Cast::class, 'cast_id');
    }

    public function Movie() {
        return $this->belongsTo(Movie::class,  'movie_id');
    }
}
