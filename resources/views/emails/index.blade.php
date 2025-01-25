<h1>Emailuri</h1>
<ul>
    @foreach ($messages as $message)
        <li>
            <strong>{{ $message->getSubject() }}</strong><br>
            De la: {{ $message->getFrom()[0]->mail }}<br>
            Data: {{ $message->getDate() }}<br>
            <a href="{{ url('/emails/'.$message->getUid()) }}">Deschide</a> |
            <form action="{{ url('/emails/1/reply') }}" method="POST">
                @csrf
                <textarea name="message" required></textarea>
                <button type="submit">Răspunde</button>
            </form>

        </li>
    @endforeach
</ul>

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
