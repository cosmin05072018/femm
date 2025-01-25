<h1>Emailuri</h1>
<ul>
    @foreach ($messages as $message)
        <li>
            <strong>{{ $message->getSubject() }}</strong><br>
            De la: {{ $message->getFrom()[0]->mail }}<br>
            Data: {{ $message->getDate() }}<br>
            <a href="{{ url('/emails/'.$message->getUid()) }}">Deschide</a> |
            <a href="{{ url('/emails/'.$message->getUid().'/reply') }}">Răspunde</a>
        </li>
    @endforeach
</ul>
