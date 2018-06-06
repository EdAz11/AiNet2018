@extends('master')

@section('title', 'List Profiles')

@section('content')
        <div class="dropdown">
                 <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Search
                </button>
                <div class="dropdown-menu">
            <form action="{{route('profiles')}}" method="get" class="form-group">
                @include('partials.search-name')
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </div>
            </form>
        </div>
        @if (count($users))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Associate</th>
                    <th>Associate-Of</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name}}</td>
                        <td>
                        @if($user->profile_photo != null)
                                {{asset('storage/profiles/'.$user->profile_photo)}}
                        @endif
                        </td>
                        <td>
                        @foreach ($user->associateMembersOf as $userAssociate)
                            @if($userAssociate->main_user_id == \Illuminate\Support\Facades\Auth::id())
                                    <span>associate</span>
                            @endif
                        @endforeach
                        </td>
                        <td>
                        @foreach ($user->associateMembers as $userAssociateOf)
                            @if($userAssociateOf->associated_user_id == \Illuminate\Support\Facades\Auth::id())
                                    <span>associate-of</span>
                            @endif
                        @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <h2>No users found</h2>
        @endif
@endsection