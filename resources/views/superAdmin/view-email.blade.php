@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <p>Mail primit de la: <b>{{ $messages->getFrom()[0]->mail }}</b></p>
            <p>Subiect: <b>{{ $messages->getSubject() }}</b></p>

            <h4>Continutul mailului:</h4>
            <div class="container-fluid p-3">
                {!! $messages->getHTMLBody() !!}
            </div>
        </div>
    </div>
@endsection
