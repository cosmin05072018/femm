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
