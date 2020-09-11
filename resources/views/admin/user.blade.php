@extends('layouts.admin')

@section('content')
<div>
    <h1>{{isset($isEdit) ? 'Edit User' : 'Add User'}}</h1>
</div>


@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(isset($isEdit))
<form name="user" action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
    @method('PATCH')
    @else
    <form name="user" action="{{route('user.add')}}" method="POST" enctype="multipart/form-data">
        @endif

        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right"><strong>Name</strong> :</label>
            <input type="text" name="name" class="form-control col-sm-6" value="{{(isset($user->name) && !old('name')) ? $user->name : old('name')}}" />
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right"><strong>Email</strong> :</label>
            <input type="text" name="email" class="form-control col-sm-6" value="{{(isset($user->email) && !old('email')) ? $user->email : old('email')}}" />
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right"><strong>Role</strong> :</label>
            <select name="role" class="form-control col-sm-6">
                <option value="">- - Select Role - -</option>
                @foreach($roles as $role)
                @if(old('role') == $role->id)
                <option value="{{$role->id}}" selected="selected">{{$role->role}}</option>
                @elseif(isset($user->role_id) && $user->role_id && !old('role') == $role->id)
                <option value="{{$role->id}}" selected="selected">{{$role->role}}</option>
                @else
                <option value="{{$role->id}}">{{$role->role}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right"><strong>Photo</strong> :</label>
            <input type="file" name="photo" class="" />
            @if(isset($user->photo))
            <img src="/storage/{{$user->photo}}" height="40" />
            @endif
        </div>

        <div class="form-group row">
            <span class="col-sm-2 "></span>
            <input type="submit" name="submit" class="btn btn-primary" value="{{isset($isEdit) ? 'Edit User' : 'Add User'}}" />
            <a href="{{route('user')}}" class="btn btn-primary mx-4">Cancel</a>

        </div>

    </form>


    @endsection