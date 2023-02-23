@extends('layouts.auth')
@section('title') Восстановление пароля @endsection
@section('content')

<x-forms.auth-forms title="Восстановление пароля" action="{{route('password-reset.handle')}}" method="POST">
    <input type="hidden" name="token" value="{{$token}}">
    <x-forms.text-input
    name="email"
    placeholder="E-mail"
    required="true"
    :isError="$errors->has('email')" 
    type="email"
    value="{{ request('email')}}"
    />
    @error('email')
        <x-forms.error>{{$message}}</x-forms.error>  
    @enderror

    <x-forms.text-input
    name="password"
    placeholder="Пароль"
    required="true"
    :isError="$errors->has('password')" 
    type="password"
    value=""
    />
    @error('password')
        <x-forms.error>{{$message}}</x-forms.error>  
    @enderror


    <x-forms.text-input
        name="password_confirmation"
        placeholder="Подтверждение пароля"
        required="true"
        :isError="$errors->has('password_confirmation')" 
        type="password" 
    />
    @error('password_confirmation')
        <x-forms.error>{{$message}}</x-forms.error>  
    @enderror

    <x-forms.primary-button>Обновить пароль</x-forms.primary-button>

    <x-slot:socialAuth>
    </x-slot:socialAuth>
    
    <x-slot:buttons>
    </x-slot:buttons>

</x-forms.auth-forms>

@endsection