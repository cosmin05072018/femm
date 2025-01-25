<h1>Emailuri</h1>
<ul>
    @foreach ($messages as $message)
        <li>
            <strong>{{ $message->getSubject() }}</strong><br>
            De la: {{ $message->getFrom()[0]->mail }}<br>
            Data: {{ $message->getDate() }}<br>
            <a href="#">Deschide</a> | <a href="#">Răspunde</a>
        </li>
    @endforeach
</ul>
