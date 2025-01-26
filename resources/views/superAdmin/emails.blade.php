@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Emailuri</h1>
            <ul>
                @foreach ($messages as $message)
                    <li>
                        <strong>{{ $message->getSubject() }}</strong><br>
                        De la: {{ $message->getFrom()[0]->mail }}<br>
                        Data: {{ $message->getDate() }}<br>
                        <p>Conținut: {{ $message->textBody() }}</p>
                        <p>Conținut: {{ $message->htmlBody() }}</p>
                        <p>Conținut: {{ $message->content() }}</p>
                        <p>Conținut: {{ $message->messageBody() }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
