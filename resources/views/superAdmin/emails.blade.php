@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <div class="py-5">
                <h1>Emailuri</h1>
                    @foreach ($messages as $email)
                    <tr>
                        <td>{{ $email['subject'] }}</td>
                        <td>{{ $email['from_email'] }}</td> <!-- Afișează doar adresa de e-mail -->
                        <td>{{ $email['body'] }}</td>
                    </tr>
                @endforeach
            </div>
        </div>
    </div>
@endsection
