@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Mail primit de la: {{ $messages->getFrom()[0]->mail }}</h1>

            {!! $messages->getHTMLBody() !!}

        </div>
    </div>
@endsection
