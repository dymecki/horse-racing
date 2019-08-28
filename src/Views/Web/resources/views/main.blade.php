@extends('layout')

@section('content')

<p>Horse Racing Simulator</p>

<form action="" method="post">
    @csrf
    <button>progress</button>
    <input type="submit" value="create race"/>
</form>

@endsection
