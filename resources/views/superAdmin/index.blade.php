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
            @foreach($admins as $admin)
                <tr>
                    <td>{{$admin->id}}</td>
                    <td>{{$admin->firstname}}</td>
                    <td>{{$admin->lastname}}</td>
                    <td>{{$admin->email}}</td>
                    <td>{{$admin->google_id}}</td>
                    <td>{{$admin->facebook_id}}</td>


                    <td>
                        <form action="{{ url('/api/users/delete', $admin->id)}}" method="post">
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