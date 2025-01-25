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

<form action="{{ route('createEmail') }}" method="POST">
    @csrf
    <div>
        <label for="email">Adresa Email:</label>
        <input type="text" name="email" id="email" required placeholder="exemplu">
    </div>
    <div>
        <label for="domain">Domeniu:</label>
        <input type="text" name="domain" id="domain" required placeholder="example.com">
    </div>
    <div>
        <label for="password">Parola:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="quota">Spațiu (MB, opțional):</label>
        <input type="number" name="quota" id="quota" placeholder="0 pentru nelimitat">
    </div>
    <button type="submit">Creează Email</button>
</form>
