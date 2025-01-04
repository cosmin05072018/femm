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
                <button id="backButton" class="btn btn-outline-primary d-inline-flex align-items-center custom-btn">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </button>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hotel selectat:
                        <b>{{ $hotelSelected->name ?? 'Numele hotelului nu este disponibil' }}</b></h6>
                </div>
                <section class="bg-light p-3 shadow-sm">
                    <div class="row">
                        {{ $hotelSelected }}
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
