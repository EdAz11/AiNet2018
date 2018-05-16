@extends('master')

@section('title', 'Edit Password')

@section('content')
    <form action="{{route('users.password')}}" method="post" class="form-group">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="inputOldPassword">Old Password</label>
            <input
                    type="password" class="form-control"
                    name="oldPassword" id="inputOldPassword"
            />
        </div>
        <div class="form-group">
            <label for="inputPassword">Password</label>
            <input
                    type="password" class="form-control"
                    name="password" id="inputPassword"
            />
        </div>
        <div class="form-group">
            <label for="inputPasswordConfirmation">Password confirmation</label>
            <input
                    type="password" class="form-control"
                    name="password_confirmation" id="inputPasswordConfirmation"/>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a class="btn btn-default" href="{{route('profiles')}}">Cancel</a>
        </div>
    </form>
@endsection