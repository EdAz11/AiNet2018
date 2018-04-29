@extends('master')

@section('title', 'Personal Finances Assistant')

@section('content')
<div>
    <p>Número de Contas: {{$accounts}}</p>
    <p>Número de utilizadores: {{$users}}</p>
    <p>Número de movimentos: {{$movements}}</p>
</div>
<a class="btn btn-default" href="{{route('login')}}">Login</a>
<a class="btn btn-default" href="{{route('register')}}">Register</a>
@endsection