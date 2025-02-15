@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')

    @foreach ($emails as $email)
    <div class="email">
        <h3>{{ $email->subject }}</h3>
        <p><strong>De la:</strong> {{ $email->from }}</p>
        <p><strong>Data:</strong> {{ $email->date }}</p>
        <p>{{ Str::limit($email->body, 200) }}</p>
        <a href="{{ route('emails.show', $email->id) }}">Vezi detalii</a>
    </div>
@endforeach
{{ $emails->links() }}

@endsection
