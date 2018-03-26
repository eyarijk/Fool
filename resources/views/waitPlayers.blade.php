@extends('layouts.app')

@section('content')
    <p>Зачекайте ще: {{  $game->players - $game->player->count() }} гравця.</p>
@endsection