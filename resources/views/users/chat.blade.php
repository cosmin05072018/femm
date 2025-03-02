@extends('layouts.userslayout')

@section('title', 'Chat')

@section('content-users')

@vite(['resources/js/app.js'])

    <div id="app">
        <h1>hello</h1>
        <chat-component></chat-component>
    </div>

@endsection
