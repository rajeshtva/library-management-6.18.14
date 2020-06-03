@extends('layouts.app')

@section('content')
<div class="col-md-10 col-lg-offset-1">
    <h1><i class="fa fa-users"></i> @yield('name')
        <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a>
        <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a>

        <a href="/users" class="btn btn-default pull-right">Users</a>
    <a href="/books" class="btn btn-default pull-right">Books</a>
    <a href="/users/trashed" class="btn btn-default pull-right">Deleted Users</a>
    <a href="/books/trashed" class="btn btn-default pull-right">Deleted Books </a>
    </h1>
    <hr>
    @yield('admin-content')
    @endsection
</div>