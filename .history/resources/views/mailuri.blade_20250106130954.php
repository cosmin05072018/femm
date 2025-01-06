<table>
    <thead>
        <tr>
            <th>Subiect</th>
            <th>Expeditor</th>
            <th>Mesaj</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($emails as $email)
        <tr>
            <td>{{ $email['subject'] }}</td>
            <td>{{ $email['from_name'] ? $email['from_name'] : $email['from_email'] }}</td>
            <td>{{ $email['body'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
