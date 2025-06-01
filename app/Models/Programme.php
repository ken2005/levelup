<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Programme extends Model
{
    use HasFactory;

    protected $table = "programme";

    protected $fillable = ["name","details","statut"];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id_user = Auth::user()->id;
        });
    }
}
