@extends('layouts.layout')

@section('title', 'Utilizatori')

@section('content')
    <!-- DataTales Example -->
    <div class="card card-custom-users shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Evidență utilizatori și cereri în așteptare</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
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
                    @foreach ($users as $user)
                        <tr>
                            @php
                                $counter = 1;
                            @endphp
                            <td>{{ $loop->iteration }}</td>
                            <td class='{{ $user->county ? '' : 'text-danger' }}'>
                                {{ $user->county ? $user->county : 'Nu sunt informatii' }}</td>
                            <td class='{{ $user->company_address ? '' : 'text-danger' }}'>
                                {{ $user->company_address ? $user->company_address : 'Nu sunt informatii' }}</td>
                            <td class='{{ $user->email ? '' : 'text-danger' }}'>
                                {{ $user->email ? $user->email : 'Nu sunt informatii' }}</td>
                            <td
                                class="{{ $user->status == 0 ? 'text-warning' : ($user->status == 1 ? 'text-success' : 'text-danger') }}">
                                {{ $user->status == 0 ? 'În așteptare' : ($user->status == 1 ? 'Aprobat' : 'Respins') }}
                            </td>
                            <td class='{{ $user->role_id ? '' : 'text-danger' }}'>
                                {{ $user->role ? $user->role->name : 'Nu sunt informatii' }}</td>
                            <td class='{{ $user->department_id ? '' : 'text-danger' }}'>
                                {{ $user->department ? $user->department->name : 'Nu sunt informatii' }}</td>
                            <td class='{{ $user->hotel_name ? '' : 'text-danger' }}'>
                                {{ $user->hotel_name ? $user->hotel_name : 'Nu sunt informatii' }}
                            </td>
                            <td>
                                @if ($user->role && $user->role->name == 'owner')
                                    <span class="text-success font-weight-bold">TU ESTI OWNER</span>
                                @elseif ($user->status == 0)
                                    <div class="d-flex flex-column">
                                        <a href="#" class="btn btn-custom-action btn-sm mb-2"
                                            style="width: fit-content" title="Vezi cererea" data-bs-toggle="modal"
                                            data-bs-target="#userRequestModal-{{ $user->id }}">
                                            Vezi cererea
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                title="Șterge cererea">Șterge cererea</button>
                                        </form>
                                    </div>
                                @elseif ($user->status == 1)
                                    <div class="d-flex flex-column">
                                        <a href="{{ $user->id }}" style="width: fit-content"
                                            class="btn btn-custom-action btn-sm mb-2" title="Vezi detalii"
                                            data-bs-toggle="modal" data-bs-target="#userDetailsModal-{{ $user->id }}">
                                            Vezi detalii
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ $user->id }}" style="width: fit-content"
                                                class="btn btn-danger btn-sm mb-2" title="Șterge" data-bs-toggle="modal"
                                                data-bs-target="#DeleteUseModal-{{ $user->id }}">
                                                Șterge
                                            </a>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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

        document.querySelectorAll('.generate-password').forEach(button => {
            button.addEventListener('click', function() {
                // Căutăm cel mai apropiat .password-container dinaintea acestui buton
                const container = this.closest('.mb-3').previousElementSibling;
                if (container && container.classList.contains('password-container')) {
                    const passwordField = container.querySelector('.password-field');
                    if (passwordField) {
                        passwordField.value = generateStrongPassword();
                    }
                }
            });
        });
    });
</script>
