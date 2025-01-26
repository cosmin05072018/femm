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
                @endforeach


            </ul>
        </div>
    </div>
@endsection
