@extends('layouts.app')

@section('content')
<h3>Add Book</h3>
    <div class="" id="">
        <form class="form-inline my-2 my-lg-0" method="GET" action="{{ route('store') }}" >
            <input class="form-control mr-sm-2" type="text" name="isbn" placeholder="ISBN">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Add</button>
        </form>
    </div>
@endsection