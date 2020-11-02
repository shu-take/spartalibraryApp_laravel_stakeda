@extends('layouts.app')

@section('content')
    @if ($book['error'])
        {{ $book['error'] }}
    @else
        <h3>{{ $book['title'] }}</h3>
        <img src="{{ $book['img_url'] }}"><br>
        <p>概要:{{ $book['contents'] }}</p>
        <p>ISBN:{{ $book['isbn'] }}</p>
        <div class="" id="">
            <form class="form-inline my-2 my-lg-0" method="POST" action="{{ route('store') }}" enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="title" value="{{ $book['title'] }}">
                <input type="hidden" name="contents" value="{{ $book['contents'] }}">
                <input type="hidden" name="isbn" value="{{ $book['isbn'] }}">
                <input type="hidden" name="img_url" value="{{ $book['img_url'] }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Add</button>
            </form>
        </div>
    @endif
@endsection