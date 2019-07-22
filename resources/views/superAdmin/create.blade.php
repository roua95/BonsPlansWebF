@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Add Admin
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('superAdmin.store') }}">
                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="id">Admin ID:</label>
                    <input type="number" class="form-control" name="id"/>
                </div>
                <div class="form-group">
                    <label for="name">Admin FirstName :</label>
                    <input type="text" class="form-control" name="firstname"/>
                </div>
                <div class="form-group">
                    <label for="name">Admin LastName :</label>
                    <input type="text" class="form-control" name="lastname"/>
                </div>
                <div class="form-group">
                    <label for="name">Admin Email :</label>
                    <input type="email" class="form-control" name="email"/>
                </div>

                <div class="form-group">
                    <label for="name">Admin Password :</label>
                    <input type="password" class="form-control" name="password"/>
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection