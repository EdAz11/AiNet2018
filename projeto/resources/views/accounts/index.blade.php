@extends('master')

@section('title', 'List accounts')

@section('content')
    @if (count($accounts))
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Account's Code</th>
            <th>Type</th>
            <th>Current Balance</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($accounts as $account)
        <tr>
            <td>{{ $account->code}}</td>
            <td>{{ $account->type['name']}}</td>
            <td>{{ $account->current_balance}}</td>
        </tr>
        @endforeach
    </table>
@else
    <h2>No accounts found</h2>
@endif
@endsection
