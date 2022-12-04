<?php

/* namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\Parcelle;
use App\Models\User;

class UsersController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(UsersDataTable $dataTable){
        return $dataTable->render('users');
    }

    public function user(){
        $parcelles = Parcelle::with('user', 'proprietaire', 'village')->get();
        return $parcelles;
    }
    public function adduser(){
       
        $users = User::all();
        return view("adduser",[
            "users"=>$users,
        ]);
    }
    
    
    public function saveuser(Request $req){
        $validatedData = $req->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',

        ]);

        

        $user = new User;
        $user->name = $req->name;
        $user->email =$req->email;
        $user->username = $req->username;
        $user->password =$req->password;
        $user->role = $req->role;
        $user->save();
        return redirect("/users");
    }

    public function deleteuser($id){
        DB::table('users')->where('id', $id)->delete();
        return redirect("/users");
    }
    public function edituser($id){
        $user = DB::table('users')->where('id',$id)->first();

        return view('edituser',['user' => $user]);
    }

    public function Updateuser(Request $req){
        $validatedData = $req->validate([
            "id" => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'role' => 'required ',
        ]);

        if($req->hasFile("image")){

            $file = $req->file('image');
            $image = time().'.'.$file->getClientOriginalExtension();
            $destinationPath ='images/';
            $file->move($destinationPath,$image);

            DB::table("users")
            ->where('id', $req->id)
            ->update([
                'avatar' => $image,
            ]);

        }


        DB::table("users")
        ->where('id', $req->id)
        ->update([
            'firstName' => $req->firstname,
            'lastName' => $req->lastname,
            'telephone' => $req->phone,
            'gender' => $req->gender,
            'role' => $req->role,
        ]);
        return redirect("/users");
    }

}

 */
//laravelproject\app\Http\Controllers\UserController.php

 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Parcelle;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
 
class UsersController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = [];
            $data = User::select('id','username','name','email', 'role')->get();
            foreach($data as $row){
                $items = Parcelle::where('user_id', $row->id)->get();
                $row["nbparcelle"] = $items->count();
                array_push($users, $row);
            }
            return Datatables::of($users)->addIndexColumn()
                ->addColumn('action', function($users){
                    $button = '<button type="button" name="edit" id="'.$users->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '   <button type="button" name="edit" id="'.$users->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                })
                ->make(true);
        }
 
        return view('users');
    }
    public function search(Request $req){
        $prs = [];

        $users = [];

        $data = User::where($req->type, 'like' ,"%$req->key%")->get();

        foreach($data as $row){
            $items = Parcelle::where('user_id', $row->id)->get();
            $row["nbparcelle"] = $items->count();
            array_push($users, $row);
        }

        foreach($users as $d){
            $editUrl = route('users.edit', $d->id);

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
 
    public function store(Request $request)
    {

        $rules = array(
            'name' => 'required',
            'email' => 'required',
            'username' => 'required|unique:users|min:3',
            'password' => 'required|min:3',
            'role' =>  'required|in:admin,agent'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
 
        $pass = $request->password;
        $postpass = Hash::make($pass);
 
        $form_data = array(
            'name'        =>  $request->name,
            'email'         =>  $request->email,
            'username'         =>  $request->username,
            'role'         =>  $request->role,
            'password'         =>  $postpass
        );
 
        // User::create($form_data);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->password = $request->password;
        $user->save();
 
        return response()->json(['success' => 'Data Added successfully.']);
    }
 
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = User::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }
 
    public function update(Request $request)
    {
        $rules = array(
            'name' =>  'required',
            'email' =>  'required',
            'role' => 'required'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
 
        $form_data = array(
            'name'    =>  $request->name,
            'email'     =>  $request->email,
            'role'     =>  $request->role
        );
 
        User::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Data is successfully updated']);
    }
 
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
    }
}