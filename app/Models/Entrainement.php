<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Entrainement extends Model
{
    use HasFactory;

    protected $table = "training";

    protected $fillable = ["id_programme","details"];

    /*
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id_user = Auth::user()->id;
        });
    }
        */
}
