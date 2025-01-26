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
                                <tbody>
                                    <!-- inbox header -->
                                    <tr>
                                        <td>
                                            <btn class="btn btn-outline-primary">
                                                <input type="checkbox" class="all" title="select all"> All
                                            </btn>
                                        </td>
                                        <td>
                                            <button class="btn btn-light"><i title="delete selected"
                                                    class="fa fa-trash"></i></button>
                                            <button class="btn btn-light"><i title="move to folder"
                                                    class="fa fa-folder-open"></i></button>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <!-- inbox item -->
                                    @foreach ($sortedMessages as $message)
                                        @if (
                                            !str_contains($message->getSubject(), 'Client Configuration') &&
                                                !str_contains($message->bodies['text'] ?? '', 'Client Configuration'))
                                            <tr>
                                                <td>
                                                    <label>
                                                        <input type="checkbox">
                                                    </label> <span
                                                        class="name text-truncate">{{ $message->getFrom()[0]->mail }}</span>
                                                </td>
                                                <td><span class="subject">{{ $message->getSubject() }}</span>
                                                </td>
                                                <td><span class="badge">{{ $message->getDate() }}</span> <span
                                                        class="float-right fa fa-paperclip"></span></td>
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
