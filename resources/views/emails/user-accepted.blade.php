<!DOCTYPE html>
<html>
<head>
    <title>Cont Aprobat</title>
</head>
<body>
    <p>Bună, {{ $userName }}!</p>
<p>Contul tău a fost aprobat. Detaliile contului tău sunt:</p>
<ul>
    <li>Link de conectare: <a>{{ $link }}</a></li>
    <li>Email: {{ $email }}</li>
    <li>Parola: {{ $password }}</li>
</ul>
<p>Dupa ce te-ai conectat, din motive de securitate te rugam sa schimbi parola. Nu ne asumam daca nu ai facut acest lucru.</p>

</body>
</html>
