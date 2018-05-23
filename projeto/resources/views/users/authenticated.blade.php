@extends('master')

@section('title', 'List users')

@section('content')
@can('list', App\User::class)
@if (count($users))
    @include('partials.search')
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
        <td>{{$user->blockedToStr()}}</td>
        <td>
            @can('block', $user)
            <form action="{{route('admins.block', $user)}}" method="POST" role="form" class="inline">
                @csrf
                @method('patch')
                <button type="submit" class="btn btn-xs btn-primary">Block</button>
            </form>
            @endcan
            @can('unblock', $user)
            <form action="{{route('admins.unblock', $user)}}" method="POST" role="form" class="inline">
                @method('patch')
                @csrf
                <button type="submit" class="btn btn-xs btn-primary">Unblock</button>
            </form>
            @endcan
            @can('promote', $user)
            <form action="{{route('admins.promote', $user)}}" method="POST" role="form" class="inline">
                @csrf
                @method('patch')
                <button type="submit" class="btn btn-xs btn-primary">Promote</button>
            </form>
            @endcan
            @can('demote', $user)
            <form action="{{route('admins.demote', $user)}}" method="POST" role="form" class="inline">
                @method('patch')
                @csrf
                <button type="submit" class="btn btn-xs btn-primary">Demote</button>
            </form>
            @endcan
        </td>
    </tr>
    @endforeach
</table>
    {!! $users->render() !!}
@else
<h2>No users found</h2>
@endif
@endcan
@endsection

