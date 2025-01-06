<!-- resources/views/mailuri.blade.php -->

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emailuri</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Emailuri</h1>

    <!-- Tabelul care va afișa emailurile -->
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

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
