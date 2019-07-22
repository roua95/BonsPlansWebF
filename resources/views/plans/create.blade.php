@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Add Category
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
            <form method="post" action="{{ url('/api/plans/store') }}">
                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="id">Plan ID:</label>
                    <input type="number" class="form-control" name="id"/>
                </div>

                <div class="form-group">
                    <label for="name">Plan title :</label>
                    <input type="text" class="form-control" name="title"/>
                </div>
                <div class="form-group">
                    <label for="name">Longitude :</label>
                    <input type="number" class="form-control" name="longitude"/>
                </div>
                <div class="form-group">
                    <label for="name">Latitude :</label>
                    <input type="number" class="form-control" name="lattitude"/>
                </div>
                <div class="form-group">
                    <label for="name">Region :</label>
                    <input type="text" class="form-control" name="region"/>
                </div>
                <div class="form-group">
                    <label for="name">Adress :</label>
                    <input type="text" class="form-control" name="adresse"/>
                </div>
                <div class="form-group">
                    <label for="name">Rate :</label>
                    <input type="number" class="form-control" name="rate"/>
                </div>
                <div class="form-group">
                    <label for="name">Description :</label>
                    <input type="text" class="form-control" name="description"/>
                </div>
                <div class="form-group">
                    <label for="name">User_id :</label>
                    <input type="number" class="form-control" name="user_id"/>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection