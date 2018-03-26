@extends('layouts.app')

@section('content')
    <form action="{{ route('game.create') }}" method="post">
        {{ csrf_field() }}
        <input type="number" name="countPlayer" placeholder="Кількість гравців (макс. 6)">
        <input type="submit" value="Створити">
    </form>
@endsection