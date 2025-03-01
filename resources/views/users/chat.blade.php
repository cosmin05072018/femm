@extends('layouts.userslayout')

@section('title', 'Chat')

@section('content-chat')
    <div id="app">
        <chat-component></chat-component>
    </div>

    @vite('resources/js/app.js')

@endsection
