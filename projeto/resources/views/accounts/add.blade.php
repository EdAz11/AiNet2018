@extends('master')

@section('title', 'Add user')

@section('content')
    @if ($errors->count() > 0)
        @include('partials.errors')
    @endif
    <form action="{{route('account.save')}}" method="post" class="form-group">
        @csrf
        @include('accounts.partials.add-edit')
        <div class="form-group">
            <label for="inputDate">Date</label>
            <input
                    type="text" class="form-control"
                    name="date" id="inputDate"
                    value="{{old('date')}}"/>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success" name="ok">Add</button>
            <a class="btn btn-default" href="{{route('accounts', $user)}}">Cancel</a>
        </div>
    </form>
@endsection
