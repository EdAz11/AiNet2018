@extends('master')

@section('title', 'Statistics')

@section('content')
    @if ($movements != null)        
        <div>
            <form action="{{route('statistics')}}">
                
                <td>From</td>
                <input type="date" name="From" name="interval1" value="{{old('interval1')}}"></td>
                <td>Until</td>
                <input type="date" name="Until" name="interval2" value="{{old('interval2')}}"></td>
                
                <input type="submit" value="Search">
            </form>
        </div>
            
            
        <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>End Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($idKey as $key)
                    <tr>
                        <td>
                            {{$key}}
                        </td>
                        <td>
                            {{$byCategory[$key]}} €
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
            
        <div>
            @foreach($monthlyData as $month)
                <div name="Monthly Expenses">
                    <table>
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    

    @else
        <h2>Nada a apresentar</h2>
    @endif
@endsection
