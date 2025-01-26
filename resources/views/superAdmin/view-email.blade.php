@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')

    <style>
        .content-mail {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important;
        }
    </style>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <p class="text-dark">Mail primit de la: <b>{{ $messages->getFrom()[0]->mail }}</b></p>
            <p class="text-dark">Subiect: <b>{{ $messages->getSubject() }}</b></p>

            <p class="text-dark">Continutul mailului:</p>
            <div class="container-fluid p-3 content-mail">
                {!! $messages->getHTMLBody() !!}
            </div>
        </div>
    </div>
@endsection
