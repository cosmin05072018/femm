@extends('layouts.layout')

@section('title', 'Hotel')

@section('content')
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hotelul: nume hotel</h6>
                </div>
                <section class="bg-light p-3 shadow-sm">
                    <div class="row">
                        @foreach ($hotels as $hotel)
                            <ul>
                                <li>
                                    {{ $hotel }}
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
