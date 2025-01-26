@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Messages from: {{ $mailAdressView }}</h1>

            @foreach ($messages as $message)
                {{ $message }}
            @endforeach
        </div>
    </div>
@endsection
