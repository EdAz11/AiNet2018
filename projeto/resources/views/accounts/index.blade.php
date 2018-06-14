@extends('master')

@section('title', 'List Accounts')

@section('content')
    <a class="btn btn-primary btn-success" href="{{route('account.render')}}">Add Account</a>
    @if (count($accounts))
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Account's Code</th>
            <th>Current Balance</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($accounts as $account)
        <tr>
            <td>{{ $account->code}}</td>
            <td>{{ $account->current_balance}}</td>
            <td>{{ $account->type->name }}</td>
            <td>
                @if(!$account->trashed())
                <form action="{{route('account.destroy', $account)}}" method="POST" role="form" class="inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
                <form action="{{route('account.close', $account)}}" method="POST" role="form" class="inline">
                    @method('patch')
                    @csrf
                    <button type="submit" class="btn btn-xs btn-primary">Close</button>
                </form>
                <a class="btn btn-xs btn-primary" href="{{route('account.editRender', $account)}}">Edit</a>
                <a class="btn btn-xs btn-primary" href="{{route('movements', $account)}}">Movements</a>
                @else
                <form action="{{route('account.open', $account)}}" method="POST" role="form" class="inline">
                    @method('patch')
                    @csrf
                    <button type="submit" class="btn btn-xs btn-primary">Open</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
        {{$accounts->render()}}
    </table>
@else
    <h2>No accounts found</h2>
@endif
@endsection
