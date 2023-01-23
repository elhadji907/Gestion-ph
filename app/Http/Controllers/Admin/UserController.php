<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        /* $this->middleware(['role:super-admin']); */
        $this->middleware('permission:view-user|create-user|edit-user|destroy-user', ['only' => ['index']]);
         $this->middleware('permission:create-user', ['only' => ['create','store']]);
         $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
         $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Utilisateurs';
        if ($request->ajax()) {
            $users = User::latest();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('created_at', function ($category) {
                    return date_format(date_create($category->created_at), "d/m/yy");
                })
                ->addColumn('avatar', function ($user) {
                    $src = asset('assets/img/avatar.png');
                    if (!empty($user->avatar)) {
                        $src = asset('storage/users/'.$user->avatar);
                    }
                    return '<img src="'.$src.'" class="avatar-img rounded-circle" width="50" />';
                })
                ->addColumn('role', function ($row) {
                    foreach ($row->getRoleNames() as $role) {
                        return '<span>'.$role.'</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("users.edit", $row->id).'" class="editbtn"><button class="btn btn-sm bg-primary-light"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('users.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-sm bg-danger-light"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-user')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-user')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['avatar','role','action'])
                ->make(true);
        }
        return view('admin.users.index', compact(
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Créer un utilisateur';
        $roles = Role::get();
        return view('admin.users.create', compact('title','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:100',
            'email'=>'required|email|unique:users,email',
            'role'=>'required',
            'password'=>'required|confirmed|max:200',
            'avatar'=>'nullable|file|image|mimes:jpg,jpeg,gif,png',
        ]);
        $imageName = null;
        if ($request->hasFile('avatar')) {
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'avatar' => $imageName,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        $notifiation = notify('utilisateur créé avec succès');
        return redirect()->route('users.index')->with($notifiation);
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        foreach ($user->getRoleNames() as $key => $role) {
            $role = Role::findByName($role);
        }

        $title = "Modifier l’utilisateur";
        $roles = Role::get();
        return view('admin.users.edit',compact(
            'title','roles','user', 'role'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name'=>'required|max:100',
            'email'=>'required|email',
            'role'=>'required',
            'password'=>'nullable|confirmed|max:200',
            'avatar'=>'nullable|file|image|mimes:jpg,jpeg,gif,png',
        ]);
        $imageName = $user->avatar;
        $password = $user->password;
        if($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        if(!empty($request->password) && ($user->password != $request->password)){
            $password = Hash::make($request->password);
        }
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'avatar' => $imageName,
            'password' => $password,
        ]);
        foreach($user->getRoleNames() as $userRole){
            $user->removeRole($userRole);
        }
        $user->assignRole($request->role);
        $notification = notify('Mise à jour réussie par l’utilisateur');
        return redirect()->route('users.index')->with($notification);
    }

    public function profile(){
        $title = 'Profil utilisateur';
        $roles = Role::get();
        return view('admin.users.profile',compact(
            'title','roles'
        ));
    }

    public function updateProfile(Request $request,User $user){
        $this->validate($request,[
            'name' => 'required|min:5|max:200',
            'email' => 'required|email',
            'username' => 'nullable|min:3|max:200',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif'
        ]);
        $imageName = $user->avatar;
        if($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'avatar' => $imageName,
        ]);
        $notification = notify('Profil mis à jour avec succès');
        return redirect()->route('profile')->with($notification);
    }

    /**
     * Update current user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, User $user)
    {
        $this->validate($request, [
            'current_password'=>'required',
            'password'=>'required|max:200|confirmed',
        ]);
        $verify_password = password_verify($request->current_password, $user->password);
        if ($verify_password) {
            $user->update(['password'=>Hash::make($request->password)]);
            $notification = notify('Le mot de passe utilisateur a été mis à jour avec succès!!!');
            $logout = auth()->logout();
            return back()->with($notification, $logout);
        } elseif(!$verify_password) {
            $notification = notify("Ancien mot de passe incorrect!!!",'danger');
            return back()->with($notification);
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
        return User::findOrFail($request->id)->delete();
    }
}
