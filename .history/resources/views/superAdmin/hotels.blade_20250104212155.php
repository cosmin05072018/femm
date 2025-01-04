@extends('layouts.layout')

@section('title', 'Hoteluri')

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
                    <h6 class="m-0 font-weight-bold text-primary">Hoteluri</h6>
                </div>
                <section class="bg-light p-3 shadow-sm">
                    <div class="row">
                        @foreach ($hotelsWithEmployeeCount as $hotel)
                            <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                                <div class="card w-100 text-center">
                                    <div class="card-body d-flex flex-column">
                                        <h3 class="card-title">{{ $hotel->name }}</h3>
                                        <p class="card-text mb-4">Adresă: {{ $hotel->address }}</p>
                                        <p class="card-text mb-4">Total angajati: {{ $hotel->employee_count }}</p>
                                        <a href="{{ route('admin.hotel.show', ['id' => $hotel->id]) }}">Vezi mai multe</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
