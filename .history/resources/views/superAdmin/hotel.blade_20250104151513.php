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
    <div id="content-wrapper border-0" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <button id="backButton" class="btn btn-outline-primary d-inline-flex align-items-center custom-btn">
                <i class="fas fa-arrow-left me-2"></i> Back
            </button>
            <div class="mt-5 card shadow mb-4">
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
            </div>

            <div class="mt-5 card shadow mb-4">
                <div class="card-header py-3 d-flex">
                    <h3 class="card-title">
                        <i class="fas fa-user-tie me-2 text-primary"></i> Angajați
                    </h3>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <form>
                            <!-- Input Nume -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="name" class="form-label">Nume</label>
                                <input type="text" class="form-control " id="name" placeholder="Introduceti numele"
                                    required>
                            </div>

                            <!-- Input Număr de Telefon -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="phone" class="form-label">Număr de Telefon</label>
                                <input type="tel" class="form-control " id="phone"
                                    placeholder="Introduceti numărul de telefon" required>
                            </div>

                            <!-- Input Email -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control " id="email"
                                    placeholder="Introduceti adresa de email" required>
                            </div>

                            <!-- Select Sef Departament -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="role" class="form-label">Rol</label>
                                <select class="form-select" id="role" required>
                                    <option value="0" disabled selected>-- Selectați rolul --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">
                                            @if ($role->name == 'admin')
                                                Șef Departament
                                            @elseif($role->name == 'user')
                                                Angajat
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Departament -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="department" class="form-label">Departament</label>
                                <select class="form-select" id="department" required>
                                    <option value="0" disabled selected>-- Selectați departamentul --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Buton Submit -->
                            <div class="mb-3 col-md-4 col-12 p-0">
                                <button type="submit" class="btn btn-primary ">Salvează</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('backButton').addEventListener('click', function() {
            window.history.back();
        });
    </script>

@endsection
