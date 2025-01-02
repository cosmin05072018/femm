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
                <div class="card-body d-flex flex-column gap-5">
                    <select name="hotel" id="hotel" class="form-select">
                        <option value="" disabled selected>Selectează un hotel</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel['id'] }}">{{ $hotel['name'] }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary">Confirmă hotelul selectat</button>
                </div>
            </div>
        </div>
    </div>
@endsection
