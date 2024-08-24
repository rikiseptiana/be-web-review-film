<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Profile extends Model
{
   use HasFactory, HasUuids;

    protected $table="profile";
    
    protected $fillable = [
        'age',
        'bio',
        'address',
        'user_id',
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public $timestamps = false;
}