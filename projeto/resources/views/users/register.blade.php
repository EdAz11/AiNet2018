@extends('master')

@section('title', 'New User')

@section('content')
<form action="{{route('users.store')}}" method="post">
    @csrf
    <div>
        <label for="inputName">Name</label>
        <input
                type="text"
                name="name" id="inputName" value="{{old('name', $user->name)}}"/>
        @if($errors->has('name'))
            <em>{{$errors->first('name')}}</em>
        @endif
    </div>
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
                name="password" id="inputPassword" value="{{old('password')}}"/>
        @if($errors->has('password'))
            <em>{{$errors->first('password')}}</em>
        @endif
    </div>
    <div>
        <label for="inputPasswordConfirmation">Password confirmation</label>
        <input
                type="password"
                name="password_confirmation" id="inputPasswordConfirmation"/>
    </div>
    <div >
        <label for="inputPhone">Phone</label>
        <input
                type="text"
                name="phone" id="inputPhone" value="{{old('phone', $user->phone)}}"/>
    </div>
    <div>
        <label for="inputPhoto">Photo</label>
        <input
                type="file" class="form-control-file"
                name="profile_photo" id="inputPhoto"/>
    </div>
    <div>
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a class="btn btn-default" href="{{route('users.index')}}">Cancel</a>
    </div>
</form>
@endsection
