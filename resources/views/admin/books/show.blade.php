@extends('admin.layouts.app')

@section('title', '| Add User')

@section('admin-content')


<div class="container" style="font-size: 1.5rem">
  @section('name') Book : {{ $book->id }} @endsection
  <div class="row justify-content-between d-flex align-items-between">
    <div class="mr-3 mb-0">
      <h3 class="mb-0">{{ $book->book_name }}</h3>
    </div>
    <form action="/carts/store" method="POST">
    @csrf
      <input type="hidden" name="book_id" value="{{ $book->id }}">
      <input type="submit" value="Add To Cart" class="btn btn-primary">
    </form>
  </div>

  <div class="row justify-content-between  d-flex">
    <div> <strong> Author: </strong> </div>
    <div> {{ $book->author_name }}</div>
  </div>
  <div class="row ">
    <div> <strong> Description: </strong> </div>
    <div class="ml-3"> {{ $book->description }}</div>
  </div>

  @endsection