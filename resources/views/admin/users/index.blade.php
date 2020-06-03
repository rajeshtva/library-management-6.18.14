{{-- \resources\views\users\index.blade.php --}}

@section('title', '| Users')

@extends('admin.layouts.app')

@section('admin-content')

@section('name') All Users @endsection

@section('button')
<a href="{{ route('users.create') }}"> <button class="btn btn-success">Add User</button></a>
@endsection
<div class="table-responsive">
    <table class="table table-striped">

        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date/Time Added</th>
                <th>Roles</th>
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
                        <button class="btn btn-primary pull-left mr-3 ">Edit</button></a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="/users/{{ $user->id }}"><button class="btn btn-warning ml-3 ">user page </button></a>

                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>


</div>


@endsection