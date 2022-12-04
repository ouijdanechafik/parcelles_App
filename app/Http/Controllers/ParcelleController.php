<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataTables\ParcellesDataTable;
use App\Models\Proprietaire;
use App\Models\Village;
use App\Models\User;
use App\Models\Parcelle;

use Auth;
use DB;
use File;
use Response;

use PhpOffice\PhpWord\TemplateProcessor;

class ParcelleController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(ParcellesDataTable $dataTable){
        return $dataTable->render('parcelles');
    }

    public function searchparcelles(Request $req){
        
        $prs = [];

        $data = DB::table('parcelles')
        ->join('users', 'parcelles.user_id', '=', 'users.id')
        ->join('villages', 'parcelles.village_id', '=', 'villages.id')
        ->join('proprietaires', 'parcelles.proprietaire_id', '=', 'proprietaires.id')
        ->where('numero', $req->key)
        ->orWhere('users.name', 'like' , "%$req->key%")
        ->select('parcelles.*', 'users.name as nom_agent', 'villages.nom as village_nom', 'proprietaires.nom as p_nom')->get();

        $a = 'action';
        $l = 'link';

        $disable = 'disabled';

        if(Auth::user()->role == "admin"){
            $disable = '';
        }

        foreach($data as $d){
            $editUrl = route('editparcelle', $d->id);

            $action = "
                <div class='row'>
                <div class='col'>
                <a href='$editUrl' class='btn btn-primary '>Editer</a>
                </div>
                <div class='col'>
                <a href='#'  onclick='deletefn($d->id)' class='btn btn-danger ' >Supprimer</a>
                </div>
                </div>
            ";

            $downloadUrl = route('getdmi', $d->id);

            $link = "
            <div class='row'>
            <div class='col'>
            <a href='$downloadUrl' class='btn btn-success $disable' target='_blank'>Telecharger</a>
            </div>
            </div>
            ";

            $d->$a = $action;
            $d->$l = $link;
            array_push($prs, $d);
        }

        return $prs;

    }

    public function download($id){
        if(Auth::user()->role == 'admin'){
            $data = DB::table('parcelles')
                ->join('users', 'parcelles.user_id', '=', 'users.id')
                ->join('villages', 'parcelles.village_id', '=', 'villages.id')
                ->join('proprietaires', 'parcelles.proprietaire_id', '=', 'proprietaires.id')
                ->where('parcelles.id', $id)
                ->select(
                    'parcelles.*', 
                    'villages.nom as village_nom', 
                    'proprietaires.nom as p_nom',
                    'proprietaires.prenom as p_prenom',
                    'proprietaires.adresse as p_adresse'
                )
                ->first();

            $tmpProcessor = new TemplateProcessor(base_path().'/public/'.'model/dmi.docx');
            $tmpProcessor->setValue('nom_p', $data->p_nom);
            $tmpProcessor->setValue('prenom_p',$data->p_prenom);
            $tmpProcessor->setValue('date_dmi', $data->date_delimation);
            $tmpProcessor->setValue('adresse_p',$data->p_adresse);
            $tmpProcessor->setValue('nom_village', $data->village_nom);
            $tmpProcessor->setValue('numero_parcelle',$data->numero);

            $ldate = date('Y-m-d_H-i-s');
            
            $pathToSave = base_path().'/public/'."download/demande_d_immatriculation_$ldate.docx";
            $tmpProcessor->saveAs($pathToSave);

            return response()->download($pathToSave)->deleteFileAfterSend(true);

        }else{
            return "Don't have access";
        }
    }

    
    public function addparcelle(){
       
        $isAdmin = false;
        $agents = [];
        if(Auth::user()->role == 'admin'){
            $isAdmin = true;
            $agents = User::where('role','agent')->get();
        }

        $proprietaires = Proprietaire::all();
        $villages = Village::all();
        
        return view("addparcelle",[
            "villages" =>$villages,
            "proprietaires"=>$proprietaires,
            'agents' => $agents,
            'isAdmin' => $isAdmin
        ]);
    }

    

    public function save(Request $req){
        $validatedData = $req->validate([
            'numero' => 'required|integer|unique:parcelles',
            'Date_delimitation' => 'required',
            'village_id' => 'required',
            'proprietaire_id' => 'required',
            'signature' => 'required',
        ]);

        $villages = Village::where('id', $req->village_id);
        if($villages->count() == 0){
            return back()->with('error', "Village n'existe pas!");
        }

        $proprietaires = Proprietaire::where('id', $req->proprietaire_id);
        if($proprietaires->count() == 0){
            return back()->with('error', "Proprietaire n'existe pas!");
        }

        $parcelle = new Parcelle;
        $parcelle->numero = $req->numero;
        $parcelle->date_delimation = $req->Date_delimitation;
        $parcelle->village_id = $req->village_id;
        $parcelle->proprietaire_id = $req->proprietaire_id;
        $parcelle->signature = $req->signature;
        if(Auth::user()->role == "agnet"){
            $parcelle->user_id = Auth::user()->id;
        }
        $parcelle->user_id = $req->agent_id;

        $parcelle->save();


        return redirect("/parcelles");
    }


    public function editparcelle($id){
        $isAdmin = false;
        $agents = [];
        if(Auth::user()->role == 'admin'){
            $isAdmin = true;
            $agents = User::where('role','agent')->get();
        }

        $proprietaires = Proprietaire::all();
        $villages = Village::all();

        $parcelle = Parcelle::find($id);
        
        return view("editparcelle",[
            "parcelle" => $parcelle,
            "villages" =>$villages,
            "proprietaires"=>$proprietaires,
            'agents' => $agents,
            'isAdmin' => $isAdmin
        ]);
    }

    public function updateparcelle(Request $req){
        $validatedData = $req->validate([
            'numero' => 'required|integer',
            'Date_delimitation' => 'required',
            'village_id' => 'required',
            'proprietaire_id' => 'required',
            'signature' => 'required',
        ]);

        $villages = Village::where('id', $req->village_id);
        if($villages->count() == 0){
            return back()->with('error', "Village n'existe pas!");
        }

        $proprietaires = Proprietaire::where('id', $req->proprietaire_id);
        if($proprietaires->count() == 0){
            return back()->with('error', "Proprietaire n'existe pas!");
        }

        $parcelle = Parcelle::find($req->id);
        $parcelle->numero = $req->numero;
        $parcelle->date_delimation = $req->Date_delimitation;
        $parcelle->village_id = $req->village_id;
        $parcelle->proprietaire_id = $req->proprietaire_id;
        $parcelle->signature = $req->signature;
        if(Auth::user()->role == "agnet"){
            $parcelle->user_id = Auth::user()->id;
        }
        $parcelle->user_id = $req->agent_id;

        $parcelle->save();


        return redirect("/parcelles");
    }


    
    public function deleteparcelle($id){
        $data = Parcelle::findOrFail($id);
        $data->delete();

        return redirect('/parcelles');
    }
}
