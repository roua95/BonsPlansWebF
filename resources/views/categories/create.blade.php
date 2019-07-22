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
            <form method="post" action="{{ route('categories.store') }}">
                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="id">Category ID:</label>
                    <input type="number" class="form-control" name="id"/>
                </div>
                <div class="form-group">
                    <label for="name">Category Name :</label>
                    <input type="text" class="form-control" name="category_name"/>
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection