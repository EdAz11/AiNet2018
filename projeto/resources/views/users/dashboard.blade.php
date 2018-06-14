@extends('master')

@section('title', 'Dashboard')

@section('content')
    <div>
        <p>Total balance:{{number_format($total, 2)}}</p>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Current Balance</th>
                <th>Percentage </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($balances as $balance)
                <tr>
                    <td>{{$balance}}</td>
                    <td>{{number_format($balance*100/$total, 2)}} %</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection