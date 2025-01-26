@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Emailuri</h1>
            <ul>
                @php
                    // Sortăm mesajele în ordine descrescătoare după dată
                    $sortedMessages = collect($messages)->sortByDesc(function ($message) {
                        return $message->getDate();
                    });
                @endphp

                @foreach ($sortedMessages as $message)
                    @if (
                        !str_contains($message->getSubject(), 'Client Configuration') &&
                            !str_contains($message->bodies['text'] ?? '', 'Client Configuration'))
                        <li>
                            <strong>{{ $message->getSubject() }}</strong><br>
                            De la: {{ $message->getFrom()[0]->mail }}<br>
                            Data: {{ $message->getDate() }}<br>

                            {{-- Afișăm corpul real al emailului --}}
                            <p>
                                Conținut:
                                @if (isset($message->bodies['html']) && !empty($message->bodies['html']))
                                    {{-- Afișăm conținut HTML dacă există --}}
                                    {!! $message->bodies['html'] !!}
                                @elseif (isset($message->bodies['text']) && !empty($message->bodies['text']))
                                    {{-- Afișăm text simplu dacă HTML nu există --}}
                                    {{ nl2br(e($message->bodies['text'])) }}
                                @else
                                    Mesajul nu conține conținut vizibil.
                                @endif
                            </p>
                        </li>
                    @endif
                @endforeach



            </ul>
        </div>
    </div>
@endsection
