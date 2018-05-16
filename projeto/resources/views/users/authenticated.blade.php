@extends('master')

@section('title', 'List users')

@section('content')
@can('list', App\User::class)
@if (count($users))
    <table class="table table-striped">
    <thead>
    <tr>
        <th>Email</th>
        <th>Name</th>
        <th>Type</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
    <tr>
        <td>{{ $user->email}}</td>
        <td>{{ $user->name}}</td>
        <td>{{ $user->adminToStr()}}</td>
        <td>{{ $user->blockedToStr()}}</td>
        <td>
            <a class="btn btn-xs btn-primary" href="{{route('admins.block', $user)}}">Block</a>
            <a class="btn btn-xs btn-primary" href="{{route('admins.unblock', $user)}}">Unblock</a>
            <a class="btn btn-xs btn-primary" href="{{route('admins.promote', $user)}}">Promote</a>
            <a class="btn btn-xs btn-primary" href="{{route('admins.demote', $user)}}">Demote</a>
        </td>
    </tr>
    @endforeach
</table>
@else
<h2>No users found</h2>
@endif
@endcan
@endsection

