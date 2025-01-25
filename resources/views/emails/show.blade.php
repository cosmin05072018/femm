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


<form action="{{ route('createEmailAccount') }}" method="POST">
    @csrf
    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Parola</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Creează cont email</button>
</form>
