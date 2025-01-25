<h1>{{ $message->getSubject() }}</h1>
<p><strong>De la:</strong> {{ $message->getFrom()[0]->mail }}</p>
<p><strong>Data:</strong> {{ $message->getDate() }}</p>
<div>
    <strong>Mesaj:</strong>
    {!! $message->getHTMLBody() !!}
</div>

<h3>Răspunde:</h3>
<form action="{{ url('/emails/'.$message->getUid().'/reply') }}" method="POST">
    @csrf
    <textarea name="message" required></textarea>
    <button type="submit">Trimite Răspuns</button>
</form>

<a href="{{ url('/emails') }}">Înapoi la inbox</a>
