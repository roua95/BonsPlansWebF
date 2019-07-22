@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="uper">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <table class="table table-striped">
            <thead>
            <form action="{{ url('/api/users/create')}}" method="post">
                @csrf
                <button class="btn btn-outline-primary" type="submit">Add</button>
            </form>
            <tr>
                <td>ID</td>
                <td>User FirstName</td>
                <td>User LastName</td>
                <td>User email</td>
                <td>User google_id</td>
                <td>User facebook_id</td>
                <td>Delete user</td>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->firstname}}</td>
                    <td>{{$user->lastname}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->google_id}}</td>
                    <td>{{$user->facebook_id}}</td>


                    <td>
                        <form action="{{ url('/api/users/delete', $user->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
@endsection