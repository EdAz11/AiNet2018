@extends('master')

@section('title', 'My Associates')

@section('content')
    @if ($errors->count() > 0)
        @include('partials.errors')
    @endif
    <form action="{{route('profiles.storeAssociate')}}" method="POST" role="form" class="inline">
        @csrf
        <div class="form-group">
            <label for="inputAssociatedUser">Associated User</label>
            <input type="text" class="form-control" name="associated_user" id="inputAssociatedUser" value="{{old('associated_user')}}"/>
        </div>
        <button type="submit" class="btn btn-primary btn-success">Add</button>
    </form>
        @if (count($users))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                        <form action="{{route('profiles.destroyAssociate', $user)}}" method="POST" role="form" class="inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                        </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <h2>No users found</h2>
        @endif
@endsection