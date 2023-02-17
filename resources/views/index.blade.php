@extends('layouts.app')

@section('content')
    @auth
        <form method="POST" action="{{route('logout')}}">
            @csrf
            @method('DELETE')
            <button type="submit">Выход</button>
        </form>  
    @endauth

@endsection