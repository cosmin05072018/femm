@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" style="padding: 20px 10px">
            <h1>Emailuri</h1>
            <div class="container my-5">
                <!-- Taburile -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <!-- Tabul pentru Toate mesajele -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Toate mesajele</button>
                    </li>
                    <!-- Tabul pentru Mesaje necitite -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="unread-tab" data-bs-toggle="tab" data-bs-target="#unread" type="button" role="tab" aria-controls="unread" aria-selected="false">Mesaje Necitite</button>
                    </li>
                    <!-- Tabul pentru Mesaje Trimise -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab" aria-controls="sent" aria-selected="false">Mesaje Trimise</button>
                    </li>
                    <!-- Buton pentru a compune un email, mutat în dreapta -->
                    <li class="ms-auto">
                        <a href="#" class="btn btn-danger btn-sm" role="button"><i class="fa fa-edit"></i> Compune un mail</a>
                    </li>
                </ul>

                <!-- Contul pentru taburi -->
                <div class="tab-content mt-3" id="myTabContent">
                    <!-- Tabul pentru Toate mesajele -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h2 class="mb-3">Toate mesajele</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>De la:</th>
                                    <th>Subiect</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($receivedEmails as $email)
                                    @if (!str_contains($email->subject, 'Client Configuration') && !str_contains($email->body ?? '', 'Client Configuration'))
                                        <tr class="bg-transparent"
                                            onclick="window.location='{{ route('admin.view-email', ['email' => $email->id]) }}';"
                                            style="cursor: pointer;">
                                            <td class="bg-transparent">
                                                <span
                                                    class="name text-truncate {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->from }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="subject {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->subject }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-dark {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->created_at->format('d-m-Y H:i') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabul pentru Mesaje necitite -->
                    <div class="tab-pane fade" id="unread" role="tabpanel" aria-labelledby="unread-tab">
                        <h2 class="mb-3">Mesaje Necitite</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>De la:</th>
                                    <th>Subiect</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unreadEmails as $email)
                                    @if (!str_contains($email->subject, 'Client Configuration') && !str_contains($email->body ?? '', 'Client Configuration'))
                                        <tr class="bg-transparent"
                                            onclick="window.location='{{ route('admin.view-email', ['email' => $email->id]) }}';"
                                            style="cursor: pointer;">
                                            <td class="bg-transparent">
                                                <span
                                                    class="name text-truncate {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->from }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="subject {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->subject }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-dark {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->created_at->format('d-m-Y H:i') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabul pentru Mesaje trimise -->
                    <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                        <h2 class="mb-3">Mesaje Trimise</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Destinatar:</th>
                                    <th>Subiect</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sentEmails as $email)
                                    @if (!str_contains($email->subject, 'Client Configuration') && !str_contains($email->body ?? '', 'Client Configuration'))
                                        <tr class="bg-transparent"
                                            onclick="window.location='{{ route('admin.view-email', ['email' => $email->id]) }}';"
                                            style="cursor: pointer;">
                                            <td class="bg-transparent">
                                                <span
                                                    class="name text-truncate {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->to }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="subject {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->subject }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-dark {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
                                                    {{ $email->created_at->format('d-m-Y H:i') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
