@extends('layout')

@section('content')
    <style xmlns:form="http://www.w3.org/1999/html">
        .uper {
            margin-top: 40px;
        }
        .button {
            color: #b91d19;
            background-color: #ffe924;
            font-family: 'fantasy', sans-serif;
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
            <form action="{{ url('/api/plans/create')}}" method="post">
                @csrf
                <button class="btn btn-outline-primary" type="submit">Add plan</button>
            </form>
            <tr>
                <td>ID</td>
                <td>Title</td>
                <td>user_id</td>
                <td>Description</td>
                <td>Adresse</td>
                <td>Rate</td>
                <td>Longitude</td>
                <td>Latitude</td>
                <td>Edit</td>
                <td>Delete</td>
                <td>Approve</td>
                <td>Assign to category</td>

            </tr>
            </thead>
            <tbody>
            @foreach($plans as $plan)
                <tr>
                    <td>{{$plan->id}}</td>
                    <td>{{$plan->title}}</td>
                    <td>{{$plan->user_id}}</td>
                    <td>{{$plan->description}}</td>
                    <td>{{$plan->adresse}}</td>
                    <td>{{$plan->rate}}</td>
                    <td>{{$plan->longitude}}</td>
                    <td>{{$plan->lattitude}}</td>

                    <td><a href="{{ route('plans.edit',$plan->id)}}" class="btn btn-primary">Edit</a></td>

                    <td>
                        <form action="{{ url('/api/plans/delete', $plan->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ url('/api/plans/approve', $plan->id)}}" method="post">
                            @csrf
                            <button class="btn btn-primary" type="submit">Approve</button>
                        </form>
                    </td>

                    <td>
                        <form action="{{ url('/api/plans/assignToCategory', $plan->id)}}" method="post">
                            @csrf
                            <button class="btn btn-outline-primary" type="submit" name="assign">Assign to category</button>
                            <select name="category">
                               @foreach($categories as $category)
                                <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                   @endforeach
                            </select>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
@endsection