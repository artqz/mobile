@extends('layouts.app')

@section('content')
<div class="container">
 {{ $location->name }}
 @foreach($location->rooms as $room)
    <br> - {{ $room->name }}
 @endforeach
</div>
@endsection
