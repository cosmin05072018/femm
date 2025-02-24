@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" style="padding: 20px 40px">
            <div class="filter-buttons">

                <a href="{{ route('admin.emails.index', ['filter' => 'all']) }}" class="btn {{ $filter == 'all' ? 'btn-primary' : 'btn-secondary' }}">Toate mesajele</a>
                <a href="{{ route('admin.emails.index', ['filter' => 'unread']) }}" class="btn {{ $filter == 'unread' ? 'btn-primary' : 'btn-secondary' }}">Mesaje necitite</a>
                <a href="{{ route('admin.emails.index', ['filter' => 'sent']) }}" class="btn {{ $filter == 'sent' ? 'btn-primary' : 'btn-secondary' }}">Mesaje trimise</a>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Expeditor</th>
                        <th>Subiect</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emails as $email)
                        <tr class="{{ $email->is_seen ? '' : 'fw-bold' }}">
                            <td>{{ $email->sender }}</td>
                            <td>{{ $email->subject }}</td>
                            <td>{{ $email->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
