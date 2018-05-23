@extends('master')

@section('title', 'Edit Account')

@section('content')
    @if ($errors->count() > 0)
        @include('partials.errors')
    @endif
    <form action="{{route('account.edit', $account)}}" method="post" class="form-group">
        @method('put')
        @csrf
        @include('accounts.partials.add-edit')
        <div class="form-group">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a class="btn btn-default" href="{{route('accounts', $user)}}">Cancel</a>
        </div>
    </form>
@endsection