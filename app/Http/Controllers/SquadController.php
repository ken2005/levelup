<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SquadController extends Controller
{
    //
    public function view(){
        $demandes = DB::table('demande_bro')->join('users','users.id','=','demande_bro.bro_demandeur_id')->where('bro_id', Auth::user()->id)->select('users.name','users.id as userId', 'demande_bro.id as demandeId')->get();
        $gymbros1 = DB::table('gymbro')->join('users', "gymbro.id_user2",'users.id')->where('id_user1', Auth::user()->id)->get();
        $gymbros2 = DB::table('gymbro')->join('users', "gymbro.id_user1",'users.id')->where('id_user2', Auth::user()->id)->get();
        $gymbros = $gymbros1->merge($gymbros2);
        $squads = DB::table('squad')->where('id_leader', Auth::user()->id)->get();
        $squads2 = DB::table('squad_member')->join('squad', 'squad.id', '=', 'squad_member.id_squad')->where('id_user', Auth::user()->id)->get();
        return view('squad.squad', compact('demandes', 'gymbros', 'squads', 'squads2'));
    }
    public function doAddBro($idBro){
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }
        DB::table('demande_bro')->insert([
            'bro_id' => $idBro,
            'bro_demandeur_id' => Auth::user()->id,
        ]);
        return to_route('squad');
    }

    public function addBro($idBro){
        $bro = DB::table('users')->where('id', $idBro)->first();
        return view('squad.addBro', compact('bro'));
    }

    public function acceptBro($idBro){
        DB::table('gymbro')->insert([
            'id_user1' => Auth::user()->id,
            'id_user2' => $idBro,
        ]);
        DB::table('demande_bro')->where('bro_demandeur_id', $idBro)->where('bro_id', Auth::user()->id)->delete();
        return to_route('squad');
    }

    public function refuseBro($idBro){
        DB::table('demande_bro')->where('bro_demandeur_id', $idBro)->where('bro_id', Auth::user()->id)->delete();
        return to_route('squad');
    }

    public function deleteGymbro($idGymbro){
        DB::table('gymbro')->where('id', $idGymbro)->delete();
        //DB::table('Gymbro_member')->where('id_Gymbro', $idGymbro)->delete();
        return to_route('squad');
    }

    public function createSquad(){
        return view('squad.createSquad');
    }

    public function doCreateSquad(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        DB::table('squad')->insert([
            'name' => $request->name,
            'id_leader' => Auth::user()->id,
        ]);
        return to_route('squad');
    }

    public function setSquad($idSquad,$nouveauBro,$bros){
        $squad = DB::table('squad')->where('id', $idSquad)->first();
        
        $gymbros1 = DB::table('gymbro')->join('users', "gymbro.id_user2",'users.id')->where('id_user1', Auth::user()->id)->get();
        $gymbros2 = DB::table('gymbro')->join('users', "gymbro.id_user1",'users.id')->where('id_user2', Auth::user()->id)->get();
        
        $gymbros = $gymbros1->merge($gymbros2);

        if ($bros == "a") {
            $temp = [];
            foreach (DB::table("squad_member")->where('id_squad', $idSquad)->select("id_user")->get()->toArray() as $key => $resultat) {
                array_push($temp, $resultat->id_user);
            }
            $bros = implode(",", $temp);
        }

        $newbros = [];
        if (!empty($bros)) {
            foreach (explode(",", $bros) as $key => $bro) {
                if ($bro != "-1") {
                    array_push($newbros, intval($bro));
                }
            }
        }

        if ($nouveauBro != -1) {
            array_push($newbros, $nouveauBro);
        }

        $newbros1 = DB::table('gymbro')
            ->join('users', "gymbro.id_user2",'users.id')
            ->where('id_user1', Auth::user()->id)
            ->whereIn('users.id', $newbros)
            ->select('users.id','name',"users.id as userId")
            ->get();
            
        $newbros2 = DB::table('gymbro')
            ->join('users', "gymbro.id_user1",'users.id')
            ->where('id_user2', Auth::user()->id)
            ->whereIn('users.id', $newbros)
            ->select('users.id','name',"users.id as userId")
            ->get();
        
        $newbro = $newbros1->merge($newbros2);
        $broResult = [];

        foreach ($newbro as $key => $brostre) {
            array_push($broResult, implode(" CHAMP ", json_decode(json_encode($brostre), true)));
        }
        $bros = implode(' ENREGISTREMENT ', $broResult);
        
        if ($bros == "") {
            $bros = "-1";
        }
        
        return view('squad.setSquad', compact('squad','bros','gymbros'));
    }    public function doSetSquad(Request $request, $idSquad){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        DB::table('squad')->where('id', $idSquad)->update([
            'name' => $request->name
        ]);

        DB::table('squad_member')->where('id_squad', $idSquad)->delete();
        //DB::insert('insert into squad_member (id, name) values (?, ?)', [1, 'Dayle']);
        $distGym = array_unique($request->gymbro);
        for ($i=0; $i < count($distGym); $i++) { 
            # code...
            DB::table('squad_member')->insert(['id_squad'=> $idSquad,'id_user' => $distGym[$i]]);
        }

        

        return to_route('squad');
    }

    public function deleteSquad($idSquad){
        DB::table('squad')->where('id', $idSquad)->delete();
        DB::table('squad_member')->where('id_squad', $idSquad)->delete();
        return to_route('squad');
    }

    public function leaveSquad($idSquad){
        DB::table('squad_member')->where('id_squad', $idSquad)->where('id_user', Auth::user()->id)->delete();
        return to_route('squad');

    }
}
