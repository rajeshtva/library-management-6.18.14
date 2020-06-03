@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="justify-content-end d-flex align-items-baseline">
        <div class="mr-3"> <strong> CART: </strong></div>
        <div style="font-size:2rem"> {{ count(session()->get('cart')) ?? 0}} </div>
        <a href="/carts"> <button class="btn btn-warning mx-3 ">go to cart</button></a>
      </div>
    </div>
  </div>
  <div class="d-flex flex-wrap">
    <div class="row">
      @foreach($books as $book)
      <div class="col-md-3" style="margin-bottom: 40px;">
        <div class="card">
          <div class="card-header justify-content-center d-flex"> <strong> {{ $book->book_name }} </strong></div>
          @if( in_array($book->id, $already_subs) )
          <div class="card-body" style="background:yellow">
            <div class="card-title">
              {{ $book->price}}
            </div>
            <div class="text" class="card-text trunc">{{ $book->description }}</div>
            <div class="row d-flex">

              <form action="/books/unsubscribe" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <input type="submit" value="Unsubscribe" class="btn btn-danger">
              </form>
              <a href="/books/{{ $book->id }}" class="btn btn-default ml-3">show </a>

            </div>
          </div>

          @elseif(in_array($book->id, session()->get('cart')) )
          <div class="card-body" style="background:lightgreen">
            <div class="card-title">
              {{ $book->price}}
            </div>
            <div class="text" class="card-text trunc">{{ $book->description }}</div>
            <div class="row d-flex">
              <form action="/carts/delete" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <input type="submit" value="Remove from cart" class="btn btn-danger">
              </form>
              <a href="/books/{{ $book->id }}" class="btn btn-default ml-3">show </a>

            </div>
          </div>


          @else
          <div class="card-body" style="background:lightskyblue">
            <div class="card-title">
              {{ $book->price}}
            </div>
            <div class="text" class="card-text trunc">{{ $book->description }}</div>
            <div class="row d-flex">

              <form action="/carts/store" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <input type="submit" value="Add To Cart" class="btn btn-primary">
              </form>
              <a href="/books/{{ $book->id }}" class="btn btn-default ml-3">show </a>
            </div>

          </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>



<!-- <script>
  function truncateText(selector, maxLength) {
    var element = document.querySelector(selector),
        truncated = element.innerText;

    if (truncated.length > maxLength) {
        truncated = truncated.substr(0,maxLength) + '...';
    }
    return truncated;
}

document.getElementsByClassName('trunc').innerText = truncateText('div.trunc', 100);
</script> -->

@endsection