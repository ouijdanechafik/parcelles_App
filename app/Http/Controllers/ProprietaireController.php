<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ProprietaireDataTable;
use App\Models\Proprietaire;
use App\Models\Photos_identite;
use DataTables;

class ProprietaireController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(ProprietaireDataTable $dataTable, Request $request){
        // if ($request->ajax()) {
        //     return [];
        //     // $data = User::select('*');
        //     // return Datatables::of($data)
        //     //         ->addIndexColumn()
        //     //         ->addColumn('status', function($row){
        //     //              if($row->status){
        //     //                 return '<span class="badge badge-primary">Active</span>';
        //     //              }else{
        //     //                 return '<span class="badge badge-danger">Deactive</span>';
        //     //              }
        //     //         })
        //     //         ->filter(function ($instance) use ($request) {
        //     //             if ($request->get('status') == '0' || $request->get('status') == '1') {
        //     //                 $instance->where('status', $request->get('status'));
        //     //             }
        //     //             if (!empty($request->get('search'))) {
        //     //                  $instance->where(function($w) use($request){
        //     //                     $search = $request->get('search');
        //     //                     $w->orWhere('name', 'LIKE', "%$search%")
        //     //                     ->orWhere('email', 'LIKE', "%$search%");
        //     //                 });
        //     //             }
        //     //         })
        //     //         ->rawColumns(['status'])
        //     //         ->make(true);
        // }
        return $dataTable->render('proprietaire');
    }

    public function search(Request $req){
        $prs = [];

        $data = Proprietaire::where($req->type, 'like' ,"%$req->key%")->get();

        foreach($data as $d){
            $editUrl = route('editproprietaire', $d->id);

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

    public function addproprietaire(){
       
        $proprietaires = Proprietaire::all();
        return view("addproprietaire",[
            "proprietaires"=>$proprietaires,
        ]);
        
    }

    public function save(Request $req){
        $validatedData = $req->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => 'required',
            'sexe' => 'required',
            'nationalite' => 'required',
            'type_identite' => 'required|in:permis,CIN,carte de resident,PASSPORT',
            'numero_identite' => 'required|unique:proprietaires',
            'image' => 'mimes:jpeg,jpg,png|required|max:1024',
            'adresse' => 'required',

        ]);

        $file = $req->file('image');
        $image = time().'.'.$file->getClientOriginalExtension();
        $destinationPath ='images/';
        $file->move($destinationPath, $image);

        $proprietaire = new Proprietaire;
        $proprietaire->nom = $req->nom;
        $proprietaire->prenom =$req->prenom;
        $proprietaire->sexe = $req->sexe;
        $proprietaire->nationalite =$req->nationalite;
        $proprietaire->type_identite = $req->type_identite;
        $proprietaire->numero_identite =$req->numero_identite;
        $proprietaire->adresse =$req->adresse;
        $proprietaire->save();

        $photo = new Photos_identite;
        $photo->src = $image;
        $photo->proprietaire_id = $proprietaire->id;
        $photo->save();

        return redirect("/proprietaires");
    }

    public function editproprietaire($id){
       
        $proprietaire = Proprietaire::find($id);
        $photo = Photos_identite::where('proprietaire_id', $id)->first();
        // return ['p' => $proprietaire, 'photo' =>$photo];
        return view("editproprietaire",[
            "proprietaire"=>$proprietaire,
            "photo"=>$photo,
        ]);
        
    }

    public function update(Request $req){
        $validatedData = $req->validate([
            'id' => 'required',
            'id_img' => 'required',
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => 'required',
            'sexe' => 'required',
            'nationalite' => 'required',
            'type_identite' => 'required|in:permis,CIN,carte de resident,PASSPORT',
            'numero_identite' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:1024',
            'adresse' => 'required',
        ]);

        

        $proprietaire = Proprietaire::find($req->id);
        $proprietaire->nom = $req->nom;
        $proprietaire->prenom =$req->prenom;
        $proprietaire->sexe = $req->sexe;
        $proprietaire->nationalite =$req->nationalite;
        $proprietaire->type_identite = $req->type_identite;
        $proprietaire->numero_identite =$req->numero_identite;
        $proprietaire->adresse =$req->adresse;
        $proprietaire->save();


        if($req->hasFile("image")){
            $file = $req->file('image');
            $image = time().'.'.$file->getClientOriginalExtension();
            $destinationPath ='images/';
            $file->move($destinationPath, $image);

            $photo = Photos_identite::find($req->id_img);
            $photo->src = $image;
            $photo->proprietaire_id = $proprietaire->id;
            $photo->save();
        }
        

        return redirect("/proprietaires");
    }

    public function deleteproprietaire($id){

        $data = Proprietaire::findOrFail($id);
        $data->delete();

        return redirect('/proprietaires');
    }

    
    
    
}
