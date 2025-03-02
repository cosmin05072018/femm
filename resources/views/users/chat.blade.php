@extends('layouts.userslayout')

@section('title', 'Chat')

@section('content-users')

@vite(['resources/js/app.js', 'resources/css/app.css'])

<h1>hello</h1>
    <div id="app">
        <h1>hellos</h1>
        <chat-component></chat-component>
    </div>
@endsection


