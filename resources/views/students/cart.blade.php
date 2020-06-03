@extends('layouts.app')

@section('content')

<div class="row justify-content-center d-flex">
	<div class="col-md-12">
		<div class="row">
			<div class="col-12 d-flex justify-content-end mb-2">
						   <form action="/checkout" method="POST" style="display:inline"> @csrf
          <input type="submit" value="Checkout" class="btn btn-warning">
				</form>
			</div>
		</div>
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Book ID</th>
					<th scope="col">NAME</th>
					<th scope="col">AUTHOR</th>
					<th scope="col">PRICE</th>
					<th scope="col">DESCRIPTION</th>
					<th scope="col">BUTTONS</th>
				</tr>
			</thead>
			<tbody>
				@foreach($books as $book)
				<!-- <th scope="row">3</th> -->
				<td> {{$book->id }} </td>
				<td> {{ $book->book_name }} </td>
				<td> {{ $book->author_name }} </td>
				<td> {{ $book->price}} </td>
				<td> {{ $book->description }}</td>
				<td>
					<form action="/carts/delete" method="POST" style="display:inline"> @csrf 
					@method('DELETE')
					<input type="hidden" name="book_id" value="{{ $book->id }}">
          <input type="submit" value="Remove" class="btn btn-danger">
				</form>
				</td>

				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection