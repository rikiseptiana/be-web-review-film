<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Movie extends Model
{
    use HasFactory, HasUuids;

    protected $table="movie";
    protected $fillable = [

        'title',
        'summary',
        'year',
        'poster',
        'genre_id'
    ];

    public function genre(){

        return $this->belongsTo(Genre::class, 'genre_id');
    }
    public function listReview(){
        
        return $this->hasMany(Review::class, 'movie_id');
    }

    public function Cast(){
        return $this->hasMany(CastMovie::class,  'cast_id');
    }

    public $timestamps = false;
}
