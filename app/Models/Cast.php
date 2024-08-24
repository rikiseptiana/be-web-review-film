<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Cast extends Model
{
    use HasFactory, HasUuids;

    protected $table="casts";
    protected $fillable = [
        'name',
        'age',
        'bio'
    ];
    
    public function Movie() {
        return $this->hasMany(CastMovie::class, 'movie_id');
    }

    public $timestamps = false;

}
