@extends('master')

@section('title', 'Login')

@section('content')
<form action="{{route('users.login')}}" method="post">
    @csrf
<div>
    <label for="inputEmail">Email</label>
    <input
            type="email"
            name="email" id="inputEmail" value="{{old('email', $user->email)}}"/>
    @if($errors->has('email'))
        <em>{{$errors->first('email')}}</em>
    @endif
</div>
<div>
    <label for="inputPassword">Password</label>
    <input
            type="password"
            name="password" id="inputPassword"/>
</div>
<div>
    <button type="submit" class="btn btn-success" name="ok">Login</button>
    <a class="btn btn-default" href="{{route('users.index')}}">Cancel</a>
</div>
@endsection