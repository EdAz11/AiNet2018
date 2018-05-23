@extends('master')

@section('title', 'List users')

@section('content')
        @if (count($users))
            <form action="{{route('profiles')}}" method="get" class="form-group">
                @include('partials.search-name')
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Associate</th>
                    <th>Associate-Of</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name}}</td>
                        <td>
                        @if($user->profile_photo != null)
                            <a href="{{Storage::url('profiles/'.$user->profile_photo)}}">photo</a>
                        @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <h2>No users found</h2>
        @endif
@endsection