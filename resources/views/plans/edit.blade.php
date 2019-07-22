@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Edit Plan
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
            <form method="post" action="{{ route('plans.update', $plan->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="price">Plan ID :</label>
                    <input type="text" class="form-control" name="plan_ID" value={{ $plan->id }} />
                </div>
                <div class="form-group">
                    <label for="name">Plan Title:</label>
                    <input type="text" class="form-control" name="plan_title" value={{ $plan->title}} />
                </div>
                <div class="form-group">
                    <label for="name">Plan description:</label>
                    <input type="text" class="form-control" name="plan_description" value={{ $plan->description}} />
                </div>
                <div class="form-group">
                    <label for="name">User ID:</label>
                    <input type="text" class="form-control" name="category_name" value={{ $plan->user_id}} />
                </div>
                <div class="form-group">
                    <label for="name">Adresse</label>
                    <input type="text" class="form-control" name="category_name" value={{ $plan->adresse}} />
                </div>
                <div class="form-group">
                    <label for="name">Rate:</label>
                    <input type="text" class="form-control" name="category_name" value={{ $plan->rate}} />
                </div>
                <div class="form-group">
                    <label for="name">Longitude:</label>
                    <input type="text" class="form-control" name="category_name" value={{ $plan->longitude}} />
                </div>
                <div class="form-group">
                    <label for="name">Latitude:</label>
                    <input type="text" class="form-control" name="category_name" value={{ $plan->lattitude}} />
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection