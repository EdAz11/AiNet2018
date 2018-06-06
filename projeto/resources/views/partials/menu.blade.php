<div class="pull-right">
    Welcome {{Auth::user()->name}},
    <table>
        <tr>
            <td>
    <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Menu
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    @if(Auth::user()->isAdmin())
    <a href="{{route('accounts', Auth::user())}}" class="btn">My Accounts</a>
    <a href="{{route('movements', Auth::user())}}" class="btn">My Movements</a>
    <a href="{{route('admins.index')}}" class="btn">Users</a>
    @endif
    <a href="{{route('users.renderPassword')}}" class="btn">My Password Update</a>
    <a href="{{route('profile.render')}}" class="btn">My Profile Update</a>
    <a href="{{route('profiles')}}" class="btn">Profiles</a>
    <a href="{{route('profile.associates')}}" class="btn">My Associates</a>
    <a href="{{route('profile.associatesOf')}}" class="btn">Associated Of</a>
    </div>
    </div>
    </td>
    <td>
    <form action="{{route('logout')}}" method="post">
        @csrf  
    <button type="submit" class="btn">Logout</button>
    </form>
        </tr> 
    </table>
</div>
    
    