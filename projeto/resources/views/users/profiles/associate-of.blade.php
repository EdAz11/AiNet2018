@extends('master')

@section('title', 'Associate of')

@section('content')
    @if (count($users))
        <form action="{{route('profile.associatesOf')}}" method="get" class="form-group">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Account link</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->email}}</td>
                        <td>
                            <a href="{{route('accounts', $user)}}">Account link</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </form>
    @else
        <h2>No users found</h2>
    @endif
@endsection