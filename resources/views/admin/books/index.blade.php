@extends('admin.layouts.app')

@section('title', '| Add User')

@section('admin-content')
@section('name') All Books @endsection

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <table class=table>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Name</th>
          <th scope="col">Author</th>
          <th scope="col">Price</th>
          <th scope="col">Rented By</th>
          <th>Operations</th>
        </tr>
        @foreach($books as $book)
        <tr>
          <td>{{ $book->id ?? '' }}</td>
          <td>{{ $book->book_name  ?? ''}}</td>
          <td>{{ $book->description ?? ''}}</td>
          <td>{{ $book->price ?? ''}}</td>
          <td>{{ $book->rented_by ?? ''}}</td>
          <td>
            <div class="d-flex">
            <a href="/books/{{ $book->id }}"> <button class="btn btn-primary mr-3" >Detail</button></a>
            <div class="d-flex">
              <form action="/books/{{$book->id}}" method="POST" class="form-inline">
                @csrf
                @method('EDIT')
                <input type="submit" value="edit" class="btn btn-info mr-3">
              </form>
              <form action="/books/{{$book->id}}" method="POST" class="form-inline">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete" class="btn btn-danger">
              </form>
            </div>
          </td>
        </tr>

        @endforeach


      </table>
    </div>
  </div>
</div>

@endsection