<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       // abort_if(!auth()->user()?->isAdmin(),403);

        // or

       // abort_if(!auth()->user()?->is_admin,403);

      //or

        //abort_if(!auth()->user()?->role,403);


        // return Response()->json([
        //     'users' => $users,
        // ]);

       // $arr_id  = [35,36,38];
       //  $users = User::whereIn('id',$arr_id)->get();
       // $users = User::find($arr_id);
       // $users = User::findMany($arr_id);
      //  dd($users);
        $users = User::orderBy('id','desc')->paginate(5);
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roles' => 'required|exists:roles,id',
        ]);

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            $exection = $file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/', $name);
            //echo public_path().'/uploads/';
            $avatar = URL::to('/').'/uploads/'.$name;
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => $avatar?? null,
             'status' => $request->status?? 0
        ]);
        if($user){
            $arr_roles= explode(',',$request->roles);
            $roles = Role::whereIn('id',$arr_roles)->pluck('id')->toArray();
            $user->roles()->sync($roles);
        }

        return redirect()->route('admin.users.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return redirect()->route('admin.users.index')->with('error','User not found');
        }
        $roles = Role::all();
        $arr_roles = $user->roles()->pluck('role_id')->toArray();
        $user->roles = implode(',',$arr_roles);
        return view('admin.user.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roles' => 'required|exists:roles,id',
        ]);

        $user = User::find($id);
        if(!$user){
            return redirect()->route('admin.users.index')->with('error','User not found');
        }

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            $exection = $file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/', $name);
            //echo public_path().'/uploads/';
            $avatar = URL::to('/').'/uploads/'.$name;
            $user->avatar = $avatar;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status?? 0
        ]);
        if($user){
            $arr_roles= explode(',',$request->roles);
            $roles = Role::whereIn('id',$arr_roles)->pluck('id')->toArray();
            $user->roles()->sync($roles);
        }

        return redirect()->route('admin.users.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return redirect()->route('admin.users.index')->with('error','User not found');
        }
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted successfully');
    }
}
