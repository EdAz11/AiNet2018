@extends('master')

@section('title', 'List of Movements')

@section('content')
    <a class="btn btn-primary btn-success" href="{{route('movements.create', $account)}}">Add Movement</a>
    @if (count($movements))
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Category</th>
                <th>Date</th>
                <th>Value</th>
                <th>Type</th>
                <th>End Balance</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($movements as $movement)
                <tr>
                    <td></td>
                    <td>{{ $movement->date}}</td>
                    <td>{{ $movement->value}}</td>
                    <td>{{ $movement->type}}</td>
                    <td>{{ $movement->end_balance}}</td>
                    <td>
                        <form action="{{route('movements.destroy', $movement)}}" method="POST" role="form" class="inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger">Delete Movement</button>
                        </form>
                        <form action="{{route('documents.destroy', $movement)}}" method="POST" role="form" class="inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger">Delete Document</button>
                        </form>
                        <a class="btn btn-xs btn-primary" href="{{route('movements.edit', $movement)}}">Edit</a>
                        <a class="btn btn-xs btn-primary" href="{{route('documents.create', $document)}}">New Document</a>
                        <a class="btn btn-xs btn-primary" href="{{route('documents.download', $document)}}">Get Document</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <h2>No accounts found</h2>
    @endif
@endsection
