@extends('layouts.userslayout')

@section('title', 'Chat')

@section('content-users')
<h1>hello</h1>
    <div id="app">
        <chat-component></chat-component>
    </div>

    @vite('resources/js/app.js')

@endsection
