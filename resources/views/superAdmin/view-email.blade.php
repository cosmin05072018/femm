@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Messages from: {{ $mailAdressView }}</h1>

            @if ($messages->isEmpty())
                <p>No messages found from {{ $mailAdressView }}.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>From</th>
                            <th>Body</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td>{{ $message->getSubject() }}</td>
                                <td>{{ $message->getFrom()[0]->mail }}</td>
                                <td>{{ $message->getTextBody() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
