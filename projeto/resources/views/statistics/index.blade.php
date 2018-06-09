@extends('master')

@section('title', 'Statistics')

@section('content')
    @if ($movements != null)
        
        
        <div>
            <form action="{{route('users.dashboard', $user)}}" method="post"><td>From
                <input type="date" name="From" id="interval1" value=""></td>
                    <td>Until
                <input type="date" name="Until" id="interval2" value=""></td>
                
                <input type="submit" value="Search">
            </form>
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
        <div id="pie-div"></div>
        <?= Lava::render('PieChart', 'pieChart', 'pie-div') ?>
        
        
    @else
        <h2>Nada a apresentar</h2>
    @endif
@endsection
