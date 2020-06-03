@extends('admin.layouts.app')

@section('admin-content')
@section('button ')
<a href="{{ route('books.create') }}" class="btn btn-success">Add User</a>
@endsection
<div class="table-responsive">
    @section('name') Force-delete User @endsection
    <table class="table table-striped">

        <thead>
            <tr>
                <th>Name</th>
                <th>Author</th>
                <th>Price</th>
                <th>deleted_at</th>
                <th>created_at</th>
                <th>total charge</th>
                <th>subscribers</th>
                <th>actions</th>

            </tr>
        </thead>

        <tbody>
            @foreach ($books as $book)
            <tr>

                <td>{{ $book->book_name }}</td>
                <td>{{ $book->author_name }}</td>
                <td>{{ $book->price }}</td>
                <td>{{ $book->deleted_at }}</td>
                <td>{{ $book->created_at }}</td>
                <td>{{ $book->total_charge }}</td>
                <td>{{ $book->subscribers }}</td>
                <td class="d-flex ">
                    <a href="{{ route('books.edit', $book->id) }}">
                        <button class="btn btn-primary float-left">Edit</button>
                    </a>

                    <form action="/books/{{ $book->id }}/force-delete" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Force Delete" class="btn btn-danger mx-1">
                    </form>
                    <form action="/books/{{ $book->id }}/restore" method="POST">
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