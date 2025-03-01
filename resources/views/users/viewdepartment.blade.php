@extends('layouts.userslayout')

@section('title', 'Departament')

@section('content-department')
<div class="container">
    <h2>Utilizatori din Departamentul {{ $department->name }} - Hotelul {{ $department->hotel->name }}</h2>

    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }} - {{ $user->email }}</li>
        @endforeach
    </ul>
</div>
@endsection
