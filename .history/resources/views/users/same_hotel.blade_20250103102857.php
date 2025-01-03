@extends('layouts.userslayout')

@section('title', 'Departamente')

@section('content-users')
    <style>
        .card-custom:hover {
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px !important;
        }

        .card-custom form input {
            cursor: pointer !important;
        }
    </style>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <div class="py-5">
                <h1>Departamente</h1>
            </div>
            @foreach ($data as $a)
                <ul>
                    <li>{{ $a }}</li>
                </ul>
            @endforeach

        </div>
    </div>
@endsection
