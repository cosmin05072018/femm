@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <h1>Emailuri</h1>
            <ul>
                @php
                    // Sortăm mesajele în ordine descrescătoare după dată
                    $sortedMessages = collect($messages)->sortByDesc(function ($message) {
                        return $message->getDate();
                    });
                @endphp

                @foreach ($sortedMessages as $message)
                    @if (
                        !str_contains($message->getSubject(), 'Client Configuration') &&
                            !str_contains($message->bodies['text'] ?? '', 'Client Configuration'))
                        <li>
                            <strong>{{ $message->getSubject() }}</strong><br>
                            De la: {{ $message->getFrom()[0]->mail }}<br>
                            Data: {{ $message->getDate() }}<br>

                            {{-- Afișăm corpul real al emailului --}}
                            <p>
                                Conținut:
                                @if (isset($message->bodies['html']) && !empty($message->bodies['html']))
                                    {{-- Afișăm conținut HTML dacă există --}}
                                    {!! $message->bodies['html'] !!}
                                @elseif (isset($message->bodies['text']) && !empty($message->bodies['text']))
                                    {{-- Afișăm text simplu dacă HTML nu există --}}
                                    {{ nl2br(e($message->bodies['text'])) }}
                                @else
                                    Mesajul nu conține conținut vizibil.
                                @endif
                            </p>
                        </li>
                    @endif
                @endforeach
            </ul>

            <div class="container-fluid py-3">
                <div class="row">
                    <!--main-->
                    <div class="col-sm-9 col-md-10">
                        <!-- tabs -->
                        <ul class="nav nav-tabs border-0">
                            <li class="nav-item">
                                <a href="#" class="btn btn-danger btn-sm btn-block" role="button"><i class="fa fa-edit"></i> Compose</a>
                            </li>
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
                        </ul>
                        <!-- tab panes -->
                        <div class="tab-content py-4">
                            <div class="tab-pane in active" id="inbox">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <!-- inbox header -->
                                        <tr>
                                            <td>
                                                <btn class="btn btn-outline-primary">
                                                    <input type="checkbox" class="all" title="select all"> All
                                                </btn>
                                            </td>
                                            <td>
                                                <button class="btn btn-light"><i title="delete selected" class="fa fa-trash"></i></button>
                                                <button class="btn btn-light"><i title="move to folder" class="fa fa-folder-open"></i></button>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <!-- inbox item -->
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type="checkbox">
                                                </label> <span class="name text-truncate">Mark Otto</span></td>
                                            <td><span class="subject">Nice work on the docs for lastest version</span> <small class="text-muted">- Joe, I just reviewed the last...</small></td>
                                            <td><span class="badge">12:10 AM</span> <span class="float-right fa fa-paperclip"></span></td>
                                        </tr>
                                        <!-- inbox item -->
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type="checkbox">
                                                </label> <span class="name text-truncate">Anil Judah</span></td>
                                            <td><span class="subject">GAE Project</span> <small class="text-muted">- Can you take a second to look..</small></td>
                                            <td><span class="badge badge-inverse">11:33 AM</span> <span class="float-right fa fa-warning-sign text-danger"></span></td>
                                        </tr>
                                        <!-- inbox item -->
                                        <tr class="unread">
                                            <td>
                                                <label>
                                                    <input type="checkbox">
                                                </label> <span class="name text-truncate">Terry Lincoln</span></td>
                                            <td><span class="subject">Vacation pics</span> <small class="text-muted">(this message contains images)</small></td>
                                            <td><span class="badge">11:13 AM</span> <span class="float-right"></span></td>
                                        </tr>
                                        <!-- inbox item -->
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type="checkbox">
                                                </label> <span class="name text-truncate">Mark Brown</span></td>
                                            <td><span class="subject">Last call for this weekend</span> <small class="text-muted">- Hi Joe, Thanks for sending over those..</small></td>
                                            <td><span class="badge">11:05 AM</span> <span class="pull-right"></span></td>
                                        </tr>
                                        <!-- inbox item -->
                                        <tr>
                                            <td class=" text-truncate">
                                                <label>
                                                    <input type="checkbox">
                                                </label> <span class="name text-truncate">Jorge Anodonolgez</span></td>
                                            <td><span class="subject">Meeting with Simco</span> <small class="text-muted">- Joe I included your contact info for the...</small></td>
                                            <td><span class="badge">10:54 AM</span> <span class="pull-right glyphicon glyphicon-paperclip"></span></td>
                                        </tr>
                                        <!-- inbox item -->
                                        <tr>
                                            <td class="text-nowrap">
                                                <label>
                                                    <input type="checkbox">
                                                </label> <span class="name text-truncate">Mark Otto</span></td>
                                            <td><span class="subject">FYI: New Release</span> <small class="text-muted">this message is high priority</small></td>
                                            <td><span class="badge badge-dark">9:58 AM</span> <span class="float-right"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane in" id="profile">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <span class="text-center">This tab folder is empty.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
