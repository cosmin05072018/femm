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
                <section class="bg-light pt-5 pb-5 shadow-sm">
                    <div class="row">
                        @foreach ($hotels as $hotel)
                            <!--ADD CLASSES HERE d-flex align-items-stretch-->
                            <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">Dōtonbori Canal</h5>
                                        <p class="card-text mb-4">Is a manmade waterway dug in the early 1600's and now
                                            displays many landmark commercial locals and vivid neon signs.</p>
                                        <a href="#" class="btn btn-primary mt-auto align-self-start">Book now</a>
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