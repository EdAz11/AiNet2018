@extends('master')

@section('title', 'List accounts closed')

@section('content')
    @if (count($accounts))
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Account's Code</th>
                <th>Current Balance</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td>{{ $account->code}}</td>
                    <td>{{ $account->current_balance}}</td>
                    <td>{{ $account->type->name}}</td>
                </tr>
            @endforeach
        </table>
    @else
        <h2>No accounts found</h2>
    @endif
@endsection