<div class="pull-right">
    Welcome {{Auth::user()->name}},
    <form action={{route('logout')}} method="post" >
        @csrf
        <button type="submit" class="btn btn-default">Logout</button>
    </form>
</div>
