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
                <div class="card-body d-flex flex-column gap-5 w-100">
                    <section class="bg-light pt-5 pb-5 shadow-sm">
                        <div class="container">
                            <div class="row pt-5">
                                <div class="col-12">
                                    <h3 class="text-uppercase border-bottom mb-4">Equal height Bootstrap 5 cards example
                                    </h3>
                                </div>
                            </div>
                            <div class="row">
                                <!--ADD CLASSES HERE d-flex align-items-stretch-->
                                <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                                    <div class="card">
                                        <img src="https://i.postimg.cc/28PqLLQC/dotonburi-canal-osaka-japan-700.jpg"
                                            class="card-img-top" alt="Card Image">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">Dōtonbori Canal</h5>
                                            <p class="card-text mb-4">Is a manmade waterway dug in the early 1600's and now
                                                displays many landmark commercial locals and vivid neon signs.</p>
                                            <a href="#" class="btn btn-primary mt-auto align-self-start">Book now</a>
                                        </div>
                                    </div>
                                </div>
                                <!--ADD CLASSES HERE d-flex align-items-stretch-->
                                <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                                    <div class="card">
                                        <img src="https://i.postimg.cc/4xVY64PV/porto-timoni-double-beach-corfu-greece-700.jpg"
                                            class="card-img-top" alt="Card Image">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">Porto Timoni Double Beach</h5>
                                            <p class="card-text mb-4">Near Afionas village, on the west coast of Corfu
                                                island. The two beaches form two unique bays. The turquoise color of the sea
                                                contrasts to the high green hills surrounding it.</p>
                                            <a href="#" class="btn btn-primary mt-auto align-self-start">Book now</a>
                                        </div>
                                    </div>
                                </div>
                                <!--ADD CLASSES HERE d-flex align-items-stretch-->
                                <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                                    <div class="card">
                                        <img src="https://i.postimg.cc/TYyLPJWk/tritons-fountain-valletta-malta-700.jpg"
                                            class="card-img-top" alt="Card Image">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">Tritons Fountain</h5>
                                            <p class="card-text mb-4">Located just outside the City Gate of Valletta, Malta.
                                                It consists of three bronze Tritons holding up a large basin, balanced on a
                                                concentric base built out of concrete and clad in travertine slabs.</p>
                                            <a href="#" class="btn btn-primary mt-auto align-self-start">Book now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
