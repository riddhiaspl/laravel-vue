<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use App\User;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(3);
        $roles = Roles::all();

        foreach ($roles as $role)
            $roles[$role->id] = $role->role;

        return view('admin.userlist', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Roles::all();
        return view('admin.user', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
                'photo' => 'image'
            ]
        );

        $inputs['role_id'] = $request['role'];

        if ($request['photo']) {
            $inputs['photo'] = request('photo')->store('images');
        }
        User::create($inputs);

        session()->flash('message', 'User Added Successfully !!');
        return redirect()->route('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roles = Roles::all();
        $user = User::findOrFail($id);

        return view('admin.user', ['roles' => $roles, 'isEdit' => 'y', 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
                'photo' => 'image'
            ]
        );

        $inputs['role_id'] = $request['role'];

        if ($inputs['role_id'])
            unset($inputs['role']);

        if ($request['photo'] != '') {
            $user = User::findOrFail($id);

            if ($user['photo'] != '')
                @unlink(public_path('/storage/' . $user['photo']));

            $inputs['photo'] = request('photo')->store('images');
        }

        User::where('id', $id)->update($inputs);

        session()->flash('message', 'User Updated Successfully !!');
        return redirect()->route('user');
    }

    public function DeleteUserPhoto($id)
    {
        $user = User::findOrFail($id);

        if ($user['photo'] != '') {
            @unlink(public_path('/storage/' . $user['photo']));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user) {
            if ($user['photo'] != '') {
                @unlink(public_path('/storage/' . $user['photo']));
            }

            User::where('id', $id)->delete();

            session()->flash('message', 'User Deleted Successfully !!');
            return redirect()->route('user');
        }
    }
}
