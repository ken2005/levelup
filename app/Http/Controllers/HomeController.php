<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function view(){
        if (Auth::user() == null){
            return to_route('auth.login');
        }
        $exercices = DB::table("exercice")->where("id_user", Auth::user()->id)->orWhere('statut', 'public')->get();
        $maxSeries = 0;
        foreach ($exercices as $key => $exercice) {
            $exercice->series = DB::table("serie")->where('id_exercice', $exercice->id)->where("id_user", Auth::user()->id)
            ->get();
            if (count($exercice->series) > $maxSeries) {
                $maxSeries = count($exercice->series);
            }
        }
        //dd($exercices);
        //dd($entrainements);
        return view('welcome', ['exercices' => $exercices, 'maxSeries' => $maxSeries]);
    }
}
