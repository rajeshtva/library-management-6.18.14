@extends('admin.layouts.app')

@section('title', 'Borrowed books')

@section('admin-content')

@section('name') {{ $user->name }} @endsection 

    <table class="table">
        <tr>
            <td><h3>{{ $user->name }}</h3></td>
            <td><h3>{{ $user->email }}</h3></td>
            <td><h3>{{ $user->account }}</h3></td>
            <td> <h3>{{ $count }}</h3></td>
        </tr>
    </table>

    <h1 class="display-4">Book</h1>
    <table class="table-striped table">

    <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Subscribed At</th>
                    <th>Past Charges</th>
                    <th>current Charge</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($book_details as $book)
                <tr>

                    <td>{{ $book->book_id }}</td>
                    <td>{{ $book->name }}</td>
                    <td>{{ $book->created_at }}</td>
                    <td>{{ $book->past_charges}}</td>
                    <td>{{ $book->current_charge }}</td>
                </tr>
                @endforeach
    </table>

</div>


@endsection