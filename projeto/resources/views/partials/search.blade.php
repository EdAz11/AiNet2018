<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Search
  </button>
<div class="dropdown-menu">
<form action="{{route('admins.index')}}" method="get" class="form-group">
    @include('partials.search-name')
    <div>
    <div class="form-group">
        <label for="inputType">Type</label>
        <label class="radio-inline"><input type="radio" name="type" value="admin">Admin</label>
        <label class="radio-inline"><input type="radio" name="type" value="normal">Normal</label>
    </div>
    <div class="form-group">
        <label for="inputStatus">Status</label>
        <label class="radio-inline"><input type="radio" name="status" value="blocked">Blocked</label>
        <label class="radio-inline"><input type="radio" name="status" value="unblocked">Unblocked</label>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">Search</button>
    </div>
    </div>
</form>
</div>
</div>
