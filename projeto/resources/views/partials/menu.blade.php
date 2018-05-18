<div class="pull-right">
    Welcome {{Auth::user()->name}}
    <form action="{{route('logout')}}" method="post">
        @csrf
        <button type="submit" class="btn btn-default">Logout</button>
    </form>
    <a href="{{route('users.renderPassword')}}" class="btn btn-default">My Password Update</a>
    <a href="{{route('profile.render')}}" class="btn btn-default">My Profile Update</a>
    <a href="{{route('profiles')}}" class="btn btn-default">Profiles</a>
    <a href="{{route('profile.associates')}}" class="btn btn-default">My associates</a>
</div>
