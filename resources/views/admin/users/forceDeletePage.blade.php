@extends('admin.layouts.app')

@section('admin-content')
@section('button ')
<a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
@endsection
<div class="table-responsive">
    @section('name') Force-delete User @endsection
    <table class="table table-striped">

        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date/Time Added</th>
                <th>User Roles</th>
                <th>Charge</th>
                <th>Operations</th>

            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
            <tr>

                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                <td>{{ $user->account }}</td>
                <td class="d-flex ">
                    <a href="{{ route('users.edit', $user->id) }}">
                        <button class="btn btn-primary float-left">Edit</button>
                    </a>

                    <form action="/users/{{ $user->id }}/force-delete" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Force Delete" class="btn btn-danger mx-1">
                    </form>
                    <form action="/users/{{ $user->id }}/restore" method="POST">
                        @csrf
                        <input type="submit" value="restore" class="btn btn-warning">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>


</div>


@endsection