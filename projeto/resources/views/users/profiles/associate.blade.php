@extends('master')

@section('title', 'List users')

@section('content')
        @if (count($users))
            <form action="{{route('profile.associates')}}" method="get" class="form-group">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                @endforeach
            </table>
            </form>
        @else
            <h2>No users found</h2>
        @endif
@endsection