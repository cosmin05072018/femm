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

                        {{-- Afișăm conținutul mesajului --}}
                        <p>
                            Conținut:
                            @if (!empty($message->bodies['html']))
                                {{-- Afișăm HTML dacă există --}}
                                {!! $message->bodies['html'] !!}
                            @elseif (!empty($message->bodies['text']))
                                {{-- Afișăm text simplu dacă HTML nu există --}}
                                {{ nl2br(e($message->bodies['text'])) }}
                            @else
                                Mesajul nu conține conținut.
                            @endif
                        </p>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
@endsection
