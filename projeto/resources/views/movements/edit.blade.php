@extends('master')

@section('title', 'Edit Movement')

@section('content')
    @if ($errors->count() > 0)
        @include('partials.errors')
    @endif
    <form action="{{route('movements.update', $movement)}}" method="post" class="form-group">
        @method('put')
        @csrf
        @include('movements.partials.add-edit')
        @include('movements.partials.document')
        <div class="form-group">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a class="btn btn-default" href="{{route('movements', $account)}}">Cancel</a>
        </div>
    </form>
@endsection
