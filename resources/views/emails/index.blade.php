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
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required placeholder="example">
    </div>
    <div>
        <label for="domain">Domain:</label>
        <input type="text" name="domain" id="domain" required placeholder="example.com">
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">Create Email</button>
</form>
