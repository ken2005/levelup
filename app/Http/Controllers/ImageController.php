<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    //
    public function addImage(ImageRequest $request){
        if(DB::table('image')->where('id_user',Auth::user()->id)->exists()){
            DB::table('image')->where('id_user',Auth::user()->id)->delete();
        }
        $data=$request->validated();
        $image=$data['image'];
        $chemin = $image->store('images','public');
        //dd($chemin);
        DB::table('image')->insert([
            'id_user' => Auth::user()->id,
            'image' => $chemin,
        ]);
        return redirect()->route('image.view');
    }

    public function view(){
        $image=DB::table('image')->where('id_user',Auth::user()->id)->first();
        if($image==null){
            return to_route('imageForm');
        }
        return view('image.image',compact('image'));
    }

    
}
