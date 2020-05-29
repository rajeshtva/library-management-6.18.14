@extends('layouts.app')


@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">
          <h1 class="mb-0">List of Books</h1>
        </div>

        <div class="card-body">
          <table class=table>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Name</th>
              <th scope="col">Author</th>
              <th scope="col">Price</th>
              <th scope="col">Rented By</th>
            </tr>
            @foreach($books as $book)
              <tr>
                <td>{{ $book->id ?? '' }}</td>
                <td>{{ $book->book_name  ?? ''}}</td>
                <td>{{ $book->description ?? ''}}</td>
                <td>{{ $book->price ?? ''}}</td>
                <td>{{ $book->rented_by ?? ''}}</td>
              </tr>

            @endforeach


          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection