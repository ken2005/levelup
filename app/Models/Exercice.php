<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Exercice extends Model
{
    use HasFactory;

    protected $table = "exercice";

    protected $fillable = ["name","details","methode","statut"];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id_user = Auth::user()->id;
        });
    }
}
