@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper
    <div id="content-wrapper" class="d-flex flex-column">


        <div id="content mt-5">
            <p class="text-dark">Mail primit de la: <b>{{ $messages->getFrom()[0]->mail }}</b></p>
            <p class="text-dark">Subiect: <b>{{ $messages->getSubject() }}</b></p>

            <p class="text-dark">Continutul mailului:</p>
            <div class="container-fluid p-3 border b-rounded">
                {!! $messages->mask()->getHTMLBodyWithEmbeddedBase64Images() !!}
                    {{ $messages->getAttachments }}
            </div>


            <a href="#" class="btn btn-info btn-sm my-4" title="Raspunde" data-bs-toggle="modal"
                data-bs-target="#userRequestModal">
                Raspunde
            </a>


            <div class="modal fade" id="userRequestModal" tabindex="-1" aria-labelledby="userRequestModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userRequestModalLabel">Raspunde lui
                                <b>{{ $messages->getFrom()[0]->mail }}</b></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Închide"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.reply', ['email' => $messages->getUid()]) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="reply_message" rows="8"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Trimite</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
    @foreach ($emails as $email)
    <div class="email">
        <h3>{{ $email->subject }}</h3>
        <p><strong>De la:</strong> {{ $email->from }}</p>
        <p><strong>Data:</strong> {{ $email->date }}</p>
        <p>{{ Str::limit($email->body, 200) }}</p>
        <a href="{{ route('emails.show', $email->id) }}">Vezi detalii</a>
    </div>
@endforeach
{{ $emails->links() }}

@endsection
