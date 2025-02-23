@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Emailuri</h1>

            <div class="container-fluid p-0">
                <div class="row w-100">
                    <!--main-->
                    <!-- Tab-urile -->
                    <ul class="nav nav-tabs border-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#inbox" data-toggle="tab">
                                <i class="fa fa-inbox mr-1"></i> Toate mesajele
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sent" data-toggle="tab">
                                <i class="fa fa-paper-plane mr-1"></i> Mesaje Trimise
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-danger btn-sm btn-block" role="button">
                                <i class="fa fa-edit"></i> Compune un mail
                            </a>
                        </li>
                    </ul>
                    <!-- Conținutul tab-urilor -->
                    <div class="tab-content py-4">
                        <!-- Toate mesajele -->
                        <div class="tab-pane fade show active" id="inbox">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>De la:</th>
                                        <th>Subiect</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emails as $email)
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
                                                    <span
                                                        class="subject {{ $email->is_seen ? 'seen' : 'text-dark fw-bold' }}">
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

                        <!-- Mesaje Trimise -->
                        <div class="tab-pane fade" id="sent">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Către:</th>
                                        <th>Subiect</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sentEmails as $email)
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
