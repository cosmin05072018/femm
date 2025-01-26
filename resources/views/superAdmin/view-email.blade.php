@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Messages from: {{ $mailAdressView }}</h1>

            {{ $messages->getHTMLBody() }}
        </div>
    </div>
@endsection
