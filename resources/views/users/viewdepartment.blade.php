@extends('layouts.userslayout')

@section('title', 'Departament')

@section('content-department')
<div class="container">
    <h2>Utilizatori din Departamentul {{ $department->name }} - Hotelul {{ $hotel ? $hotel->name : 'Necunoscut' }}</h2>

    <ul>
        @foreach($users as $user)
            <li>{{ $user->employee_name }} - {{ $user->email }}</li>
        @endforeach
    </ul>
</div>
@endsection
