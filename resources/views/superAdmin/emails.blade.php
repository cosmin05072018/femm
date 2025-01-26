@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')

    <style>
        .bg-danger {
            background-color: red !important;
            color: white !important;
        }

        .bg-light {
            background-color: white !important;
            color: black !important;
        }
    </style>
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
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>De la:</th>
                                        <th>Subiect</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $message)
                                        @if (
                                            !str_contains($message->getSubject(), 'Client Configuration') &&
                                                !str_contains($message->bodies['text'] ?? '', 'Client Configuration'))
                                            <tr class="{{ $message->isUnread ? 'bg-danger' : 'bg-light' }}">
                                                <td>
                                                    <span
                                                        class="name text-truncate">{{ $message->getFrom()[0]->mail }}</span>
                                                </td>
                                                <td><span class="subject">{{ $message->getSubject() }}</span></td>
                                                <td><span class="text-dark">{{ $message->getDate() }}</span></td>
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
    </div>
@endsection
