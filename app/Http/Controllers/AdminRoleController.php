<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.role');
        //return $roles;
    }

    public function rolelist()
    {
        return Roles::orderBy('id', 'desc')->paginate(5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['role' => 'required|min:3|max:100']);
        if ($request['role_id'] > 0) {
            $role = Roles::findOrFail($request['role_id']);

            if ($role)
                $roleupdate = Roles::where('id', $request['role_id'])->update(['role' => $request['role']]);
        } else
            Roles::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Roles::findOrFail($id);

        if ($role)
            $roledelete = Roles::where('id', $id)->delete();
    }
}
