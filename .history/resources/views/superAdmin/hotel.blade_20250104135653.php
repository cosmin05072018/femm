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

        .custom-btn {
            display: inline-flex !important;
            width: auto !important;
            padding: 0.5rem 1rem !important;
        }
    </style>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <button id="backButton" class="btn btn-outline-primary d-inline-flex align-items-center custom-btn">
                <i class="fas fa-arrow-left me-2"></i> Back
            </button>
            <div class="mt-3 card shadow mb-4">
                <div class="card-header py-3">
                    <h2 class="m-0 font-weight-bold text-primary">
                        <span>Hotel selectat:</span>
                        <b>{{ $hotelSelected->name ?? 'Numele hotelului nu este disponibil' }}</b>
                    </h2>
                </div>
                <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                    <div class="card w-100 text-center">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle me-2 text-primary"></i> Informații
                            </h3>

                        </div>
                    </div>
                </div>
                <section class="bg-light p-3 shadow-sm">
                    <div class="row">
                        {{ $hotelSelected }}
                        <br>
                        @foreach ($users as $user)
                            {{ $user['company_name'] }}
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('backButton').addEventListener('click', function() {
            window.history.back();
        });
    </script>

@endsection
