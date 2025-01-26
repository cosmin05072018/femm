@extends('layouts.layout')

@section('title', 'Utilizatori')

@section('content')
<!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manageri de Hoteluri</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nr. Crt.</th>
                            <th>Oras</th>
                            <th>Nume Manager</th>
                            <th>Email</th>
                            <th>Status Cont</th>
                            <th>Rol</th>
                            <th>Departament</th>
                            <th>Hotel</th>
                            <th>Actiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            @php
                                $counter = 1;
                            @endphp
                            <td>{{ $loop->iteration }}</td>
                            <td  class='{{ $user->county ? '' : 'text-danger' }}'>{{ $user->county ? $user->county : 'Nu sunt informatii' }}</td>
                            <td class='{{ $user->company_address ? '' : 'text-danger' }}'>{{ $user->company_address ? $user->company_address : 'Nu sunt informatii' }}</td>
                            <td class='{{ $user->email ? '' : 'text-danger' }}'>{{ $user->email ? $user->email : 'Nu sunt informatii' }}</td>
                            <td class="{{ $user->status == 0 ? 'text-warning' : ($user->status == 1 ? 'text-success' : 'text-danger') }}">
                                {{ $user->status == 0 ? 'În așteptare' : ($user->status == 1 ? 'Aprobat' : 'Respins') }}
                            </td>
                            <td class='{{ $user->role ? '' : 'text-danger' }}'>{{ $user->role ? $user->role : 'Nu sunt informatii' }}</td>
                            <td class='{{ $user->department_id ? '' : 'text-danger' }}'>{{ $user->department ? $user->department->name : 'Nu sunt informatii' }}</td>
                            <td class='{{ $user->hotel_name ? '' : 'text-danger' }}'>
                                {{ $user->hotel_name ? $user->hotel_name : 'Nu sunt informatii' }}
                            </td>
                            <td>
                                @if ($user->role == 'owner')
                                <!-- Dacă rolul este "owner" -->
                                <span class="text-success font-weight-bold">TU ESTI OWNER</span>
                                @elseif  ($user->status == 0)
                                    <!-- Dacă statusul este 0 (în așteptare) -->
                                    <div class="d-flex flex-column">
                                        <!-- Butonul pentru activarea modalului -->
                                        <a href="#" class="btn btn-info btn-sm mb-2" title="Vezi cererea" data-bs-toggle="modal" data-bs-target="#userRequestModal-{{ $user->id }}">
                                            Vezi cererea
                                        </a>

                                        <!-- Modalul complet -->
                                        <div class="modal fade" id="userRequestModal-{{ $user->id }}" tabindex="-1" aria-labelledby="userRequestModalLabel-{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="userRequestModalLabel-{{ $user->id }}">Detalii cerere utilizator</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Închide"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form cu toate detaliile utilizatorului -->
                                                        <form id="userRequestForm-{{ $user->id }}" method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <!-- Județ -->
                                                            <div class="mb-3">
                                                                <label for="county" class="form-label">Județ</label>
                                                                <input type="text" class="form-control" id="county" name="county" value="{{ $user->county }}" readonly>
                                                            </div>

                                                            <!-- Nume Firmă -->
                                                            <div class="mb-3">
                                                                <label for="company_name" class="form-label">Nume Firmă</label>
                                                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $user->company_name }}" readonly>
                                                            </div>

                                                            <!-- CUI Firmă -->
                                                            <div class="mb-3">
                                                                <label for="company_cui" class="form-label">CUI Firmă</label>
                                                                <input type="text" class="form-control" id="company_cui" name="company_cui" value="{{ $user->company_cui }}" readonly>
                                                            </div>

                                                            <!-- Nume Manager -->
                                                            <div class="mb-3">
                                                                <label for="manager_name" class="form-label">Nume Manager</label>
                                                                <input type="text" class="form-control" id="manager_name" name="manager_name" value="{{ $user->manager_name }}" readonly>
                                                            </div>

                                                            <!-- Sediu Firmă -->
                                                            <div class="mb-3">
                                                                <label for="company_address" class="form-label">Sediu Firmă</label>
                                                                <input type="text" class="form-control" id="company_address" name="company_address" value="{{ $user->company_address }}" readonly>
                                                            </div>

                                                            <!-- Email -->
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                                                            </div>

                                                            <!-- Creare mail pentru platforma CPANEL -->
                                                            <b class="text-uppercase border-top text-center w-100">Creaza datele de autentificare pentru utilizator</b>
                                                            <div class="alert alert-primary p-3 mt-3" role="alert">
                                                                  Adresa nu trebuie sa contina "@ceva.com" deoarece i se va pune automat "@femm.ro"
                                                              </div>
                                                            <div class="mb-3">
                                                                <label for="email-femm" class="form-label">Email</label>
                                                                <input type="text" class="form-control" id="email-femm" name="email-femm">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="parola-femm" class="form-label">Parola</label>
                                                                <input type="text" class="form-control" id="parola-femm" name="parola-femm">
                                                                <button type="button" class="btn btn-secondary" id="generate-password">Generează parolă puternică</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- Buton Acceptă -->
                                                        <form action="{{ route('admin.users.accept', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success">Acceptă</button>
                                                        </form>

                                                        <!-- Buton Șterge -->
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Șterge</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Șterge utilizatorul">Șterge</button>
                                        </form>
                                    </div>
                                @elseif ($user->status == 1)
                                    <!-- Dacă statusul este 1 (aprobat) -->
                                    <div class="d-flex flex-column">
                                        <a href="{{ $user->id }}" class="btn btn-primary btn-sm mb-2" title="Vezi detalii" data-bs-toggle="modal" data-bs-target="#userDetailsModal-{{ $user->id }}">
                                            Vezi detalii
                                        </a>
                                        <!-- Modal pentru "Vezi detalii" -->
                                        <div class="modal fade" id="userDetailsModal-{{ $user->id }}" tabindex="-1" aria-labelledby="userDetailsModalLabel-{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="userDetailsModalLabel-{{ $user->id }}">Detalii Cont Utilizator</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Închide"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Afișare informații utilizator -->
                                                        <ul class="list-group">
                                                            <li class="list-group-item"><strong>Județ:</strong> {{ $user->county }}</li>
                                                            <li class="list-group-item"><strong>Nume Firmă:</strong> {{ $user->company_name }}</li>
                                                            <li class="list-group-item"><strong>CUI Firmă:</strong> {{ $user->company_cui }}</li>
                                                            <li class="list-group-item"><strong>Nume Manager:</strong> {{ $user->manager_name }}</li>
                                                            <li class="list-group-item"><strong>Sediu Firmă:</strong> {{ $user->company_address }}</li>
                                                            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                                                            <li class="list-group-item"><strong>Status Cont:</strong> {{ $user->status == 1 ? 'Aprobat' : 'Respins' }}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Închide</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Șterge utilizatorul">Șterge</button>
                                        </form>
                                    </div>
                                    @else
                                    <!-- Dacă statusul este 2 (respins)
                                    <span class="text-muted">Contul a fost respins</span>
                                    -->
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function generateStrongPassword(length = 12) {
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
            let password = "";
            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            return password;
        }

        const generateButton = document.getElementById('generate-password');
        if (generateButton) {
            generateButton.addEventListener('click', function() {
                const strongPassword = generateStrongPassword();
                document.getElementById('parola-femm').value = strongPassword;
            });
        }
    });
</script>
