@extends('layouts.layout')

@section('title', 'Emailuri')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content mt-5">


            <p class="text-dark">Continutul mailului:</p>
            <div class="container-fluid p-3 border b-rounded">
                {!! $htmlBody !!}
            </div>

            <!-- Butonul pentru activarea modalului -->
            <a href="#" class="btn btn-info btn-sm my-4" title="Raspunde" data-bs-toggle="modal" data-bs-target="#userRequestModal">
                Raspunde
            </a>


        </div>
    </div>
@endsection
