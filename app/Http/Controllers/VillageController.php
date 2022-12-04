<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Village;
use App\DataTables\VillagesDataTable;

class VillageController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(VillagesDataTable $dataTable){
        return $dataTable->render('village');
    }
    public function search(Request $req){
        $prs = [];

        $data = Village::where($req->type, 'like' ,"%$req->key%")->get();

        foreach($data as $d){
            $editUrl = route('editvillage', $d->id);

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

            $d['action'] = $action;
            array_push($prs, $d);
        }

        return $prs;

    }
    public function addvillage(){
        return view("addvillage");
    }

    public function saveVillage(Request $req) {
        $validatedData = $req->validate([
            'nom' => 'required',
        ]);

        $village = new Village;

        $village->nom = $req->nom;
        $village->save();

        return redirect('/villages');
    }

    public function editvillage($id){
        $village = Village::find($id);
        return view('editvillage', ['village' => $village]);
    }

    public function updatevillage(Request $req){
        $validatedData = $req->validate([
            'nom' => 'required',
            'id' => 'required',
        ]);


        $village = Village::find($req->id);

        $village->nom = $req->nom;
        $village->save();

        return redirect('/villages');
    }

    public function deletevillage($id){

        $data = Village::findOrFail($id);
        $data->delete();

        return redirect('/villages');
    }

}
