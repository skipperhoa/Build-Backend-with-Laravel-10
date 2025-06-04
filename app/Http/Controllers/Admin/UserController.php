<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

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

     // $arr_id  = [38,39,40];
/*       $users1 = User::whereIn('id',$arr_id)->get()->toArray();
      $users2 = User::find($arr_id)->toArray();
      $users3 = User::findMany($arr_id)->toArray();
        dd($users1,$users2,$users3); */
        $users = User::orderBy('id','desc')->paginate(5);
        Debugbar::info($users);
        Debugbar::error('Error!');
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
     * sử dụng form request "StoreUserRequest"
     */
    public function store(StoreUserRequest $request)
    {
        // code ole trước đó
       /*  $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roles' => 'required|exists:roles,id',
        ]); */

        // Code sau khi , Tối ưu với form request
        $validated = $request->validated();

        if(!$validated) {
            return redirect()->back()->withErrors($request->errors())->withInput();
        }

        Debugbar::info($request->all());

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
    public function edit(User $user)
    {
       // $user = User::find($id);
        if(!$user){
            return redirect()->route('admin.users.index')->with('error','User not found');
        }
        $roles = Role::all();
        $permissions = Permission::all(); // lấy tất cả permission
        $arr_roles = $user->roles()->pluck('role_id')->toArray(); // lấy các role_id của user
        $arr_permissions = $user->permissions()->get()->pluck('id')->toArray(); // lấy các permission_id của user
        $user->roles = implode(',',$arr_roles); // chuyển đổi mảng role_id thành chuỗi  1,2
        $user->permissions = implode(',',$arr_permissions); // chuyển đổi mảng permission_id thành chuỗi

        $roles_from_user = Role::whereIn('id', $arr_roles)->with('permissions')->get(); // lấy các role trong user
       // dd($roles_from_user->pluck('id')->toArray(), $roles_from_user->pluck('permissions')->flatten()->pluck('id')->toArray());
        if ($roles_from_user) {
            $arr_id_permission= $roles_from_user->pluck('permissions')->flatten()->pluck('id')->toArray();
            $permissions = Permission::whereNotIn('id',$arr_id_permission )->get();
        }



       // dd($user);

        return view('admin.user.edit',compact('user','roles','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

       // dd($request->all());
       /*  $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roles' => 'required|exists:roles,id',

        ]); */

        // code sau khi , tối ưu với form request
        $validated = $request->validated();

        if(!$validated) {
            return redirect()->back()->withErrors($request->errors())->withInput();
        }

        //$user = User::find($id);
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
            // lấy danh sách role theo role_id
            $roles = Role::whereIn('id',$arr_roles)->pluck('id')->toArray();

            $user->roles()->sync($roles);
            // Xử lý permissions nếu có
            if ($request->has('permissions')) {
                $arr_permissions = explode(',', $request->permissions);
                // lấy danh sách permission theo permission_id
                $permissions = Permission::whereIn('id', $arr_permissions)->pluck('id')->toArray();
                $user->permissions()->sync($permissions);
            } else {
                $user->permissions()->detach(); // Xóa tất cả permissions nếu không có
            }
        }

        return redirect()->route('admin.users.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
      //  $user = User::find($id);
        if(!$user){
            return redirect()->route('admin.users.index')->with('error','User not found');
        }
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted successfully');
    }
}
