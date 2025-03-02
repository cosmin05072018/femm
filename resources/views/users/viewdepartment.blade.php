@extends('layouts.userslayout')

@section('title', 'Departament')

@section('content-users')
    <div class="container mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column align-items-start">
                        <!--<h4 class="card-title">Add Row</h4> -->
                        <button class="btn btn-primary w-2 my-3" onclick="goBack()">
                            <i class="bi bi-arrow-left-circle"></i> Înapoi
                        </button>
                        <br>
                        <h2>Departamentul: {{ $department->name }}</h2>
                        <!--<button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">
                                <i class="fa fa-plus"></i>
                                Add Row
                            </button>-->
                    </div>
                </div>
                <div class="card-body">
                    <!-- Modal -->
                    <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title">
                                        <span class="fw-mediumbold"> New</span>
                                        <span class="fw-light"> Row </span>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="small">
                                        Create a new row using this form, make sure you fill them all
                                    </p>
                                    <form>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Employee Name</label>
                                                    <input id="addEmployeeName" type="text" class="form-control"
                                                        placeholder="Fill employee name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 pe-0">
                                                <div class="form-group form-group-default">
                                                    <label>Phone</label>
                                                    <input id="addPhone" type="text" class="form-control"
                                                        placeholder="Fill phone number" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Function</label>
                                                    <input id="addFunction" type="text" class="form-control"
                                                        placeholder="Fill function" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 pe-0">
                                                <div class="form-group form-group-default">
                                                    <label>Email FEMM</label>
                                                    <input id="addEmailFemm" type="email" class="form-control"
                                                        placeholder="Fill email" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Role</label>
                                                    <input id="addRole" type="text" class="form-control"
                                                        placeholder="Fill role" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" id="addRowButton" class="btn btn-primary">
                                        Add
                                    </button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nume angajat</th>
                                    <th>Telefon</th>
                                    <th>Functie</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Status</th>
                                    <th>Chat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (auth()->user()->id === $user->id)
                                                <span class="text-success">TU</span>
                                            @else
                                                {{ $user->employee_name }}
                                            @endif
                                        </td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->function }}</td>
                                        <td>{{ $user->email_femm }}</td>
                                        <td>
                                            @if ($user->role_id === 3)
                                                Sef departament
                                            @elseif($user->role_id === 4)
                                                Angajat
                                            @else
                                                {{ $user->role->name ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->is_logged_in == 1)
                                                <span>Activ</span>
                                                <span
                                                    style="display: inline-block; width: 10px; height: 10px; background-color: green; border-radius: 50%;"></span>
                                            @else
                                                <span>Inactiv</span>
                                                <span
                                                    style="display: inline-block; width: 10px; height: 10px; background-color: red; border-radius: 50%;"></span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.department.user', [$user->id]) }}"
                                                class="btn btn-primary btn-lg d-flex align-items-center gap-2">
                                                <span>&#128994;</span> Chat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        console.log("jQuery loaded");
        $(document).ready(function() {
            // Inițializăm DataTable și facem variabila globală
            var table = $("#add-row").DataTable({
                pageLength: 5
            });

            {{-- console.log($("#add-row")); --}}

            // Definim butoanele de acțiune
            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="Remove" class="btn btn-link btn-danger"> <i class="fa fa-times"></i> </button> </div> </td>';

            // Eveniment pentru butonul de adăugare
            $("#addRowButton").click(function() {
                // Capturăm valorile din inputuri
                var employeeName = $("#addName").val();
                var phone = $("#addPhone").val();
                var functionValue = $("#addPosition").val();
                var emailFemm = $("#addEmailFemm").val();
                var role = $("#addRole").val();
                var lastConnection = $("#addLastConnection").val();

                // Adăugăm rândul în tabel
                table.row.add([
                    '', // ID-ul generat automat
                    employeeName,
                    phone,
                    functionValue,
                    emailFemm,
                    role,
                    lastConnection,
                    action
                ]).draw();

                // Închidem modalul
                $("#addRowModal").modal("hide");

                // Resetăm formularul
                $("#addName, #addPhone, #addPosition, #addEmailFemm, #addRole, #addLastConnection").val('');
            });
        });
    </script>


@endsection
