@extends('layouts.app')


@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header d-flex align-items-center ">
          <div class="display-4 mr-5">{{ $book->book_name }}</div>
          <form action="/cart/{{ $book->id }}/add" method="POST">
            <button class="btn btn-primary">Add to cart</button>
          </form>
        </div>
        
        <div class="card-body">
            <table class="table table-borderless">
            <tr>
                <td> <h1 style="font:1.5rem; color:grey;">Author</h1></td>
                <td> <h1 style="font-size:2rem">{{ $book->author_name }}</span></td>
            </tr>
            <tr>
                <td><h1 style="font:1.5rem; color:grey;">Description<h1></td>
                <td>  <span style="font-size:2rem">{{ $book->description }}</span></td>
            </tr>
            <tr>
                <td> <h1 style="font:1.5rem; color:grey;">Price</h1></td>
                <td><span style="font-size:2rem">{{ $book->price }}</span></td>
            </tr>
            </table>
          
        </div>
      </div>
    </div>
  </div>
</div>

@endsection