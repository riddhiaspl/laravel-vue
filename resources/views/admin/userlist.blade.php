@extends('layouts.admin')

@section('content')
<div>
    <h1>Users
        <span class="float-right">
            <a href="{{ route('user.create')}}" class="btn btn-info">Add User</a>
        </span>
    </h1>
</div>

@if(session('message'))
<div class="alert alert-success">{{session('message')}}</div>
@endif
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col" style="width: 10%;">#</th>
            <th scope="col" style="width: 25%;">Name</th>
            <th scope="col" style="width: 25%;">Role</th>
            <th scope="col" style="width: 10%;">Edit</th>
            <th scope="col" style="width: 10%;">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->name}}</td>
            <td>{{ $user->role_id ? $roles[$user->role_id] : '--'}}</td>
            <td><a href="{{route('user.show', $user->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <form name="deleteUser" action="{{route('user.delete', $user->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" name="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')" value="Delete">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex">
    <div class="mx-auto">{{ $users->links() }}</div>
</div>

@endsection