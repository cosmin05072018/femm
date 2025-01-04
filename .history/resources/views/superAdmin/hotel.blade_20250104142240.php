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
                <div class="card-header py-3 d-flex">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle me-2 text-primary"></i> Informații
                    </h3>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        @foreach ($users as $user)
                            <p><span>Nume Hotel:</span> <b>{{ $user['hotel_name'] }}</b></p>
                            <p><span>Nume Manager:</span> <b>{{ $user['manager_name'] }}</b></p>
                            <p><span>Rol:</span>
                                <b>
                                    @if ($user['role'] == 'super-admin')
                                        GENERAL MANAGER
                                    @endif
                                </b>
                            </p>
                            <p><span>Mail:</span> <b>{{ $user['email'] }}</b></p>
                            <p><span>Nume Companie:</span> <b>{{ $user['company_name'] }}</b></p>
                            <p><span>CUI Companie:</span> <b>{{ $user['company_cui'] }}</b></p>
                            <p><span>Oras:</span> <b>{{ $user['county'] }}</b></p>
                            <p><span>Adresa Companie:</span> <b>{{ $user['company_address'] }}</b></p>
                        @endforeach

                    </div>
                </div>
                <section class="bg-light p-3 shadow-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Continut coloana 1</p>
                        </div>
                        <div class="col-md-6">
                            <p>Continut coloana 2</p>
                        </div>
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
