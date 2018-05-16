@extends('master')

@section('title', 'Edit Profile')

@section('content')
@if ($errors->count() > 0)
    @include('partials.errors')
@endif
<form action="{{route('profile.update')}}" method="post" class="form-group" enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="form-group">
        <label for="inputFullname">Name</label>
        <input
                type="text" class="form-control"
                name="name" id="inputFullname"
                placeholder="Name" value="{{old('name', $user->name)}}" />
    </div>
    <div class="form-group">
        <label for="inputEmail">Email</label>
        <input
                type="email" class="form-control"
                name="email" id="inputEmail"
                placeholder="Email address" value="{{old('email', $user->email)}}"/>
    </div>
    <div class="form-group">
        <label for="inputPhone">Phone</label>
        <input
                type="text" class="form-control"
                name="phone" id="inputPhone"
                value="{{old('phone', $user->phone)}}" />
    </div>
    <div class="form-group">
        <label for="inputPhoto">Photo</label>
        <input id="inputPhoto" type="file"
               name="profile_photo" value="{{ old('photo', $user->profile_photo)}}" >
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a class="btn btn-default" href="{{route('profiles')}}">Cancel</a>
    </div>
</form>
@endsection
