@extends('admin.layouts.app')

@section('title', '| Add User')

@section('admin-content')

@section('name') Create Book @endsection 
<div class="container">
  <div class="row justify-content-center">  
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>

        <div class="card-body">
          <form method="POST" action="/books">
            @csrf

            <div class="form-group row">
              <label for="book_name" class="col-md-4 col-form-label text-md-right">Book</label>

              <div class="col-md-6">
                <input id="book_name" type="text" class="form-control @error('book_name') is-invalid @enderror" name="book_name" value="{{ old('book_name') }}" required autocomplete="book_name" autofocus>

                @error('book_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="author_name" class="col-md-4 col-form-label text-md-right">Author</label>

              <div class="col-md-6">
                <input id="author_name" type="text" class="form-control @error('password') is-invalid @enderror" name="author_name" required autocomplete="author_name">

                @error('author_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

            </div>

            <div class="form-group row">
              <label for="detail" class="col-md-4 col-form-label text-md-right">Description</label>

              <div class="col-md-6">
                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description">

                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="price" class="col-md-4 col-form-label text-md-right">Price</label>

              <div class="col-md-6">
                <input id="price" type="number" class="form-control @error('password') is-invalid @enderror" name="price" required autocomplete="price" step="0.001">

                @error('price')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>


            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Register') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection