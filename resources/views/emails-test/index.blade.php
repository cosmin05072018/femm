@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Inbox</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Expeditor</th>
                <th>Destinatar</th>
                <th>Subiect</th>
                <th>Mesaj</th>
                <th>Atașamente</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emails as $email)
            <tr>
                <td>{{ $email->from }}</td>
                <td>{{ $email->to }}</td>
                <td>{{ $email->subject }}</td>
                <td>{{ Str::limit($email->body, 50) }}</td>
                <td>
                    @php $attachments = json_decode($email->attachments, true); @endphp
                    @if($attachments)
                        @foreach($attachments as $attachment)
                            <a href="{{ asset('storage/' . $attachment) }}" target="_blank">Descărcare</a><br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
