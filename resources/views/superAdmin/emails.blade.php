@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Emailuri</h1>
            @php
                // Sortăm mesajele în ordine descrescătoare după dată
                $sortedMessages = collect($messages)->sortByDesc(function ($message) {
                    return $message->getDate();
                });
            @endphp

            <div class="container-fluid p-0">
                <div class="row w-100">
                    <!--main-->
                    <!-- tabs -->
                    <ul class="nav nav-tabs border-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#inbox" data-toggle="tab">
                                <i class="fa fa-inbox mr-1"></i> Toate mesajele
                            </a>
                        </li>
                        <li><a href="#profile" class="nav-link" data-toggle="tab">
                                <i class="fa fa-user mr-1"></i> Mesaje Trimise </a></li>
                        <li><a href="#settings" class="nav-link" data-toggle="tab">
                                <i class="fa fa-plus"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-danger btn-sm btn-block" role="button"><i
                                    class="fa fa-edit"></i>
                                Compune un mail</a>
                        </li>
                    </ul>
                    <!-- tab panes -->
                    <div class="tab-content py-4">
                        <div class="tab-pane in active" id="inbox">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>De la:</th>
                                        <th>Subiect</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sortedMessages as $message)
                                        @if (
                                            !str_contains($message->getSubject(), 'Client Configuration') &&
                                                !str_contains($message->bodies['text'] ?? '', 'Client Configuration'))
                                            <a href="{{ route('admin.view-email', ['userId' => $userId]) }}">
                                                <tr class="bg-transparent">
                                                    <td class="bg-transparent">
                                                        <span
                                                            class="name text-truncate {{ $message->is_seen ? 'seen' : 'text-dark fw-bold' }}">{{ $message->getFrom()[0]->mail }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="subject {{ $message->is_seen ? 'seen' : 'text-dark fw-bold' }}">{{ $message->getSubject() }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-dark {{ $message->is_seen ? 'seen' : 'text-dark fw-bold' }}">{{ $message->getDate() }}</span>
                                                    </td>
                                                </tr>
                                            </a>
                                        @endif
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
