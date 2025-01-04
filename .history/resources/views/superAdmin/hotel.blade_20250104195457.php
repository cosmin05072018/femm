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

            <div class="mt-5 card shadow mb-4" id="formular-angajati">
                <div class="card-header py-3 d-flex">
                    <h3 class="card-title">
                        <i class="fas fa-user-plus me-2 text-primary"></i> Adaugă angajați
                    </h3>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <form action="{{ route('admin.hotel.create-user', ['id' => $hotelSelected->id]) }}" method="POST">
                            @csrf

                            <!-- Input Nume -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="name" class="form-label">Nume</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Introduceti numele"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Input Număr de Telefon -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="phone" class="form-label">Număr de Telefon</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" placeholder="Introduceti numărul de telefon"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Input Email -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Introduceti adresa de email"
                                    value="{{ old('email') }}">
                                <small class="form-text text-muted">Introduceti doar numele. Adresa de email va fi
                                    completată automat cu
                                    @femm.ro</small>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select Sef Departament -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="role" class="form-label">Rol</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role"
                                    name="role">
                                    <option value="0" disabled selected>-- Selectați rolul --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role') == $role->id ? 'selected' : '' }}>
                                            @if ($role->name == 'admin')
                                                Șef Departament
                                            @elseif($role->name == 'user')
                                                Angajat
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select Departament -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <label for="department" class="form-label">Departament</label>
                                <select class="form-select @error('department') is-invalid @enderror" id="department"
                                    name="department">
                                    <option value="0" disabled selected>-- Selectați departamentul --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buton Submit -->
                            <div class="mb-3 col-md-5 col-12 p-0">
                                <button type="submit" class="btn btn-primary w-100">Salvează</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="mt-5 card shadow mb-4" id="formular-angajati">
                <div class="card-header py-3 d-flex">
                    <h3 class="card-title">
                        <i class="fas fa-user-tie me-2 text-primary"></i> Angajați
                    </h3>
                </div>
                @foreach ($departments as $department)
                    <div class="mb-4 p-4">
                        <h3 class="text-success">Departament: <b>{{ $department->name }}</b></h3>

                        <!-- Șefi Departament -->
                        <p><b>Șefi Departament</b></p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nume</th>
                                    <th>Telefon</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach ($employees->where('department_id', $department->id)->where('role_id', 3) as $employee)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>{{ $employee->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($employees->where('department_id', $department->id)->where('role_id', 3)->isEmpty())
                            <p class="text-center">Nu sunt șefi de departament înregistrați pentru acest departament.</p>
                        @endif

                        <!-- Angajați -->
                        <p><b>Angajați</b></p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nume</th>
                                    <th>Telefon</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach ($employees->where('department_id', $department->id)->where('role_id', 4) as $employee)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>{{ $employee->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($employees->where('department_id', $department->id)->where('role_id', 4)->isEmpty())
                            <p class="text-center">Nu sunt angajați înregistrați pentru acest departament.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.getElementById('backButton').addEventListener('click', function() {
            window.location.href = 'https://femm.ro/public/fantastic-admin/hotels';
        });
    </script>

@endsection
