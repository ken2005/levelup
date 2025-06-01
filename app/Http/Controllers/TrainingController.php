<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExerciseRequest;
use App\Http\Requests\ProgramRequest;
use App\Http\Requests\TrainingRequest;
use App\Models\Entrainement;
use App\Models\Exercice;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    //
    public function view($levelUps, $powerUps){
        $programmes = DB::table('programme')
        ->leftJoin('squad_member', 'squad_member.id_squad', '=', 'programme.id_squad')
        ->where('programme.id_user', Auth::user()->id)
        ->orWhere('squad_member.id_user',Auth::user()->id)
        ->orWhere('programme.id_squad' , '0')
        ->select('programme.*')->distinct()
        ->get();
        $exos = DB::table('exercice')->leftJoin('contenir', 'contenir.id_exercice', "=", "exercice.id")->leftJoin('programme', 'contenir.id_programme', "=", "programme.id")->select([
            "exercice.*",
            "programme.id as idProgramme",
            "contenir.nb_reps"
        ])->get();
        if ($levelUps == '-1'){
            $levelUps = "";
        }
        if ($powerUps == '-1'){
            $powerUps = "";
        }
        //dd($exos);
        return view('entrainements.entrainements',["programmes" => $programmes, "tabExos" => $exos, "levelUps" => explode(",",$levelUps), "powerUps" => explode(",",$powerUps)]);
    }
    
    public function creerProgramme(){
        $squads = DB::table('squad')
        ->leftJoin('squad_member', 'squad_member.id_squad', '=', 'squad.id')
        ->where('squad_member.id_user', Auth::user()->id)
        ->orWhere('squad.id_leader', Auth::user()->id)
        ->select('squad.*')->distinct()
        ->get();
        
        return view('entrainements.creer.programme',["squads" => $squads]);
    }

    public function doCreerProgramme(ProgramRequest $request){
        $infos = $request->validated();
        //dd($infos);
        //DB::table('programme')->insert( $infos );
        $id = Programme::create([
            'name' => $infos['name'],
            'details' => $infos['details'],
            'id_squad' => $infos['statut'],
            'id_user' => Auth::user()->id
        ])->id;
        
        return to_route('modifierProgramme',["idProg" => $id,"nouvelExo" => 0,"exos" => "a"]);
    }

    public function doModifierProgramme(ProgramRequest $request,$idProg){
        $infos = $request->validated();
        DB::table('programme')->where('id',$idProg)->update([
            'name' => $infos['name'],
            'details' => $infos['details'],
            'id_squad' => $infos['statut'],
            'id_user' => Auth::user()->id
        ]);
        DB::table('contenir')->where("id_programme",$idProg)->delete();
        if ($request->exercice == null){
            $tabExercices = [];
        }
        else{
            $tabExercices = $request->exercice;
        }
        $currentOrdre = 1;
        for ($i=0; $i < count($tabExercices) ; $i++) {
            # code...
            for($j = 0; $j < $request->nb_series[$i]; $j++) {
                DB::table('contenir')->insert( [
                    'id_programme' => $idProg,
                    'id_exercice' =>  $request->exercice[$i],
                    'nb_reps' => $request->nb_reps[$i],
                    'ordre' => $currentOrdre
                ] );
                $currentOrdre++;
            }
        }        
        return to_route('training',["levelUps" => '-1',"powerUps" => '-1']);
    }
    public function modifierProgramme(Int $idProg,Int $nouvelExo,String $exos ){
        $programme = DB::table("programme")->where('id', $idProg)->first();
        $exercices = DB::table("exercice")->where('id_user', Auth::user()->id)->get();
        $squads = DB::table('squad')
        ->leftJoin('squad_member', 'squad_member.id_squad', '=', 'squad.id')
        ->where('squad_member.id_user', Auth::user()->id)
        ->orWhere('squad.id_leader', Auth::user()->id)
        ->select('squad.*')->distinct()
        ->get();
        
        $exos_contenus = DB::table("contenir")
            ->where('id_programme', $idProg)
            ->select("id_exercice", "nb_reps", "ordre", DB::raw('COUNT(*) as nb_series'))
            ->groupBy('id_exercice', 'nb_reps', 'ordre')
            ->get();
                
        return view('entrainements.modifier.programme',["programme" => $programme, "exercices" => $exercices ,"squads" => $squads, "exos_contenus" => $exos_contenus,]);
    }
    public function addExoToProg($idProg, $idExo){
        $ordre = DB::table('contenir')->where("id_programme",$idProg)->max('ordre');
        if ($ordre == null){
            $ordre = 0;
        }
        DB::table('contenir')->insert( [
            'id_programme' => $idProg,
            'id_exercice' =>  $idExo,
            'nb_reps' => null,
            'ordre' => $ordre + 1
            ] );
        return to_route('modifierProgramme',["idProg" => $idProg,"nouvelExo" => 0,"exos" => "a"]);
    }
    public function deleteExoFromProg($idProg, $idExo, $ordre){
        DB::table('contenir')->where("id_programme",$idProg)->where("id_exercice",$idExo)->
        where("ordre",$ordre)->delete();
        $exos = DB::table("contenir")->where('id_programme', $idProg)->select("id_exercice")->get();
        foreach ($exos as $key => $exo) {
            # code...
            DB::table('contenir')->where("id_programme",$idProg)->where("id_exercice",$exo->id_exercice)->update([
                'ordre' => $key + 1
            ]);
        }

        return to_route('modifierProgramme',["idProg" => $idProg,"nouvelExo" => $idExo,"exos" => "a"]);
    }

    public function supprimerProgramme($idProg){
        DB::table('programme')->delete($idProg);
        return to_route('training',["levelUps" => '-1',"powerUps" => '-1']);
    }
    public function creerExercice(){
        return view('entrainements.creer.exercice');
    }

    public function doCreerExercice(ExerciseRequest $request){
        $infos = $request->validated();
        Exercice::create($infos);
        return to_route('exercices',);
    }

    public function creerEntrainement($idProg){
        $id = DB::table('training')->insertGetId([
            'id_programme' => $idProg,
            'details' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $contenir = DB::table('contenir')->where('id_programme', $idProg)->get();
        foreach ($contenir as $key => $exo) {
            # code...
            DB::table('serie')->insert([
                'id_training' => $id,
                'id_exercice' => $exo->id_exercice,
                'dificulte' => 0,
                'nb_reps' => $exo->nb_reps,
                'ordre' => $key + 1,
                'created_at' => now(),
                'updated_at' => now(),
                'id_user' => Auth::user()->id
            ]);
        }
        return to_route('modifierEntrainement',["idEntrainement" => $id]);
    }
    public function modifierEntrainement(Int $idEntrainement){
        $entrainement = DB::table("training")->where('id', $idEntrainement)->first();
        $exercices = DB::table("exercice")->where('id_user', Auth::user()->id)->get();
        $exos = DB::table("exercice")->leftJoin('serie', 'serie.id_exercice', "=", "exercice.id")->where('serie.id_training', $idEntrainement)->select([
            "exercice.*",
            "serie.dificulte",
            "serie.nb_reps",
            "serie.id as idSerie",
        ])->get();
       
        return view('entrainements.creer.entrainement',["entrainement" => $entrainement, "exercices" => $exercices ,"exos" => $exos]);
    }

    public function ajouterExoEntrainement(TrainingRequest $request, $idEntrainement, $idExo){
        $infos = $request->validated();
        DB::table('training')->where('id',$idEntrainement)->update([
            'details' => $infos['details'],
            'updated_at' => now()
        ]);
        DB::table('serie')->where("id_training",$idEntrainement)->delete();
        if ($request->exercice == null){
            $tabExercices = [];
        }
        else{
            $tabExercices = $request->exercice;
        }
        for ($i=0; $i < count($tabExercices) ; $i++) { 
            DB::table('serie')->insert([
                'id_training' => $idEntrainement,
                'id_exercice' =>  $request->exercice[$i],
                'dificulte' => $request->dificulte[$i],
                'nb_reps' => $request->nb_reps[$i],
                'ordre' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
                'id_user' => Auth::user()->id
            ]);
        }
        
        DB::table('serie')->insert([
            'id_training' => $idEntrainement,
            'id_exercice' => $idExo,
            'dificulte' => 0,
            'nb_reps' => 0,
            'ordre' => count($tabExercices) + 1,
            'created_at' => now(),
            'updated_at' => now(),
            'id_user' => Auth::user()->id
        ]);
        return to_route('modifierEntrainement',["idEntrainement" => $idEntrainement]);
    }
    public function supprimerExoEntrainement(TrainingRequest $request, $idEntrainement, $idSerie){
        $infos = $request->validated();
        DB::table('training')->where('id',$idEntrainement)->update([
            'details' => $infos['details'],
            'updated_at' => now()
        ]);
        $ordre = DB::table('serie')->where('id', $idSerie)->value('ordre');
        DB::table('serie')->where("id_training",$idEntrainement)->delete();
        if ($request->exercice == null){
            $tabExercices = [];
        }
        else{
            $tabExercices = $request->exercice;
        }
        
        
        for ($i=0; $i < count($tabExercices) ; $i++) {
            if($i != $ordre-1) {
                DB::table('serie')->insert([
                    'id_training' => $idEntrainement,
                    'id_exercice' =>  $request->exercice[$i],
                    'dificulte' => $request->dificulte[$i],
                    'nb_reps' => $request->nb_reps[$i],
                    'ordre' => ($i >= $ordre) ? $i : $i + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'id_user' => Auth::user()->id
                ]);
            }
        }
        return to_route('modifierEntrainement',["idEntrainement" => $idEntrainement]);
    }
    public function doModifierEntrainement(TrainingRequest $request,$idEntrainement){
        $infos = $request->validated();
        DB::table('training')->where('id',$idEntrainement)->update([
            'details' => $infos['details'],
            'updated_at' => now()
        ]);
        DB::table('serie')->where("id_training",$idEntrainement)->delete();
        if ($request->exercice == null){
            $tabExercices = [];
        }
        else{
            $tabExercices = $request->exercice;

        }
        for ($i=0; $i < count($tabExercices) ; $i++) { 
            DB::table('serie')->insert( [
                'id_training' => $idEntrainement,
                'id_exercice' =>  $request->exercice[$i],
                'dificulte' => $request->dificulte[$i],
                'nb_reps' => $request->nb_reps[$i],
                'ordre' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
                'id_user' => Auth::user()->id
                ] );
        }
        
        return to_route('training',["levelUps" => '-1',"powerUps" => '-1']);
    }

    public function doCreerEntrainement(TrainingRequest $request,$idProg){
        $infos = $request->validated();
        $entrainement = Entrainement::create(['id_programme' => $idProg, 'details' => $infos['details']]);
        $levelUps = [];
        $powerUps = [];
        if ($request->exercice!= null){
            for ($i=0; $i < count($request->exercice) ; $i++) { 
                # code...
                //DB::insert('insert into contenir (id_programme, id_exercice, nb_reps) values (?, ?, ?)', [$idProg, $request->exercice[$i], $request->nb_reps[$i]]);
                $meilleureSerie = DB::table('serie')->where('id_exercice',$request->exercice[$i])->where("id_user", Auth::user()->id)->orderBy('dificulte', 'DESC')->first();
                $values = [ 'id_training' => $entrainement->id, 'dificulte' => $request->dificulte[$i], 'id_exercice' =>  $request->exercice[$i], 'nb_reps' => $request->nb_reps[$i], 'id_user' => Auth::user()->id ];
                if ($meilleureSerie != null){
    
                    if ($request->dificulte[$i] > $meilleureSerie->dificulte) {
                        $exo = DB::table("exercice")->where('id',$request->exercice[$i])->first();
                        if ($request->nb_reps[$i] >= $meilleureSerie->nb_reps) {
                            array_push($levelUps, $exo->name);
                            $values["levelup"] = true;
                        }
                        else{
                            array_push($powerUps, $exo->name);
                            $values["powerup"] = true;
    
                        }
                    }
                }
                DB::table('serie')->insert( $values );
            }
        }
        if ($levelUps == []){
            array_push($levelUps,"-1");
        }
        if ($powerUps == []){
            array_push($powerUps,"-1");
        }
        return to_route('training',['levelUps' => implode(',',$levelUps),'powerUps' => implode(',',$powerUps)]);
    }

    public function historique($idProg){
        $entrainements = DB::table("training")->where('id_programme', $idProg)->orderBy('created_at', 'DESC')->get();
        foreach ($entrainements as $key => $entrainement) {
            $entrainement->programme = DB::table("programme")->where('id', $entrainement->id_programme)->first();
            $entrainement->programme->contenir = DB::table("contenir")->where('id_programme', $idProg)->get();
            $entrainement->series = DB::table("serie")->where('id_training', $entrainement->id)->join('users', 'serie.id_user', '=', 'users.id')->select(["serie.*","users.name as userName"])->/*where('id_user', Auth::user()->id)->*/get();
            $entrainement->levelup = false;
            $entrainement->powerup = false;
            foreach ($entrainement->series as $key => $serie){
                $serie->exercice = DB::table("exercice")->where('id', $serie->id_exercice)->first();
                if ($serie->levelup){
                    $entrainement->levelup = true;
                }
                if ($serie->powerup){
                    $entrainement->powerup = true;
                }
            }
            
        }
        //dd($entrainements);
        return view('entrainements.historique',["entrainements" => $entrainements,"idProg" => $idProg]);
    }
    
    public function exercices() {
        $exercices = DB::table('exercice')->where('id_user', Auth::user()->id)->get();
        return view('exercices', ['exercices' => $exercices]);
    }

    public function enregistrerExercice(Request $request) {
        DB::table('exercice')->insert([
            'name' => $request->name,
            'methode' => $request->methode,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('exercices');
    }

    public function modifierExercice($id) {
        $exercice = DB::table('exercice')->where('id', $id)->first();
        return view('exercices.modifier', ['exercice' => $exercice]);
    }

    public function mettreAJourExercice(Request $request, $id) {
        DB::table('exercice')->where('id', $id)->update([
            'name' => $request->name,
            'methode' => $request->methode,
            'details' => $request->details,
            'updated_at' => now()
        ]);

        return redirect()->route('exercices');
    }

    public function supprimerExercice($id) {
        DB::table('exercice')->where('id', $id)->delete();
        return redirect()->route('exercices');
    }


    public function consulterExercice($id) {
        $exercice = DB::table('exercice')->where('id', $id)->first();
        $series = DB::table('serie')
        ->join('training', 'serie.id_training', '=', 'training.id')
            ->where('id_exercice', $id)
            ->orderBy('created_at', 'asc')
            ->select('serie.*', 'training.created_at as date')
            ->get();
            
        return view('exercices.consulter', [
            'exercice' => $exercice,
            'series' => $series
        ]);
    }

    
        public function exosListApi($muscle) {
            return view('exoslistapi', ['muscle' => $muscle]);
        }

        public function creerApi($exo)
            {
                return view('exercices.creerapi', ['exo' => $exo]);
            }
        
    
        public function saveExerciseFromApi($name) {
            DB::table('exercice')->insert([
                'name' => urldecode($name),
                'methode' => 'API Import',
                'description' => 'Imported from API',
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            return redirect()->route('exercices');
        }
    

}