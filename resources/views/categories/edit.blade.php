@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Edit Catgory
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
            <form method="post" action="{{ route('categories.update', $category->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="price">Category ID :</label>
                    <input type="text" class="form-control" name="category_ID" value={{ $category->id }} />
                </div>
                <div class="form-group">
                    <label for="name">Category Name:</label>
                    <input type="text" class="form-control" name="category_name" value={{ $category->category_name}} />
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection