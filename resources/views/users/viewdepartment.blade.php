@extends('layouts.userslayout')

@section('title', 'Departament')

@section('content-users')
<div class="container">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Add Row</h4>
              <button
                class="btn btn-primary btn-round ms-auto"
                data-bs-toggle="modal"
                data-bs-target="#addRowModal"
              >
                <i class="fa fa-plus"></i>
                Add Row
              </button>
            </div>
          </div>
          <div class="card-body">
            <!-- Modal -->
            <div
              class="modal fade"
              id="addRowModal"
              tabindex="-1"
              role="dialog"
              aria-hidden="true"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">
                      <span class="fw-mediumbold"> New</span>
                      <span class="fw-light"> Row </span>
                    </h5>
                    <button
                      type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-label="Close"
                    >
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
                            <input
                              id="addEmployeeName"
                              type="text"
                              class="form-control"
                              placeholder="Fill employee name"
                            />
                          </div>
                        </div>
                        <div class="col-md-6 pe-0">
                          <div class="form-group form-group-default">
                            <label>Phone</label>
                            <input
                              id="addPhone"
                              type="text"
                              class="form-control"
                              placeholder="Fill phone number"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group form-group-default">
                            <label>Function</label>
                            <input
                              id="addFunction"
                              type="text"
                              class="form-control"
                              placeholder="Fill function"
                            />
                          </div>
                        </div>
                        <div class="col-md-6 pe-0">
                          <div class="form-group form-group-default">
                            <label>Email FEMM</label>
                            <input
                              id="addEmailFemm"
                              type="email"
                              class="form-control"
                              placeholder="Fill email"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group form-group-default">
                            <label>Role</label>
                            <input
                              id="addRole"
                              type="text"
                              class="form-control"
                              placeholder="Fill role"
                            />
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer border-0">
                    <button
                      type="button"
                      id="addRowButton"
                      class="btn btn-primary"
                    >
                      Add
                    </button>
                    <button
                      type="button"
                      class="btn btn-danger"
                      data-dismiss="modal"
                    >
                      Close
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-responsive">
                <table
                id="add-row"
                class="display table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Phone</th>
                    <th>Function</th>
                    <th>Email FEMM</th>
                    <th>Role</th>
                    <th>Last Connection</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Phone</th>
                    <th>Function</th>
                    <th>Email FEMM</th>
                    <th>Role</th>
                    <th>Last Connection</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <!-- Rânduri de utilizatori vor fi adăugate din JavaScript -->
                </tbody>
              </table>

              <!-- Modal pentru adăugarea unui rând nou -->
              <div class="modal" id="addRowModal" tabindex="-1" aria-labelledby="addRowModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addRowModalLabel">Add New Employee</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="addEmployeeForm">
                        <div class="mb-3">
                          <label for="addName" class="form-label">Employee Name</label>
                          <input type="text" class="form-control" id="addName" required>
                        </div>
                        <div class="mb-3">
                          <label for="addPhone" class="form-label">Phone</label>
                          <input type="text" class="form-control" id="addPhone" required>
                        </div>
                        <div class="mb-3">
                          <label for="addFunction" class="form-label">Function</label>
                          <input type="text" class="form-control" id="addFunction" required>
                        </div>
                        <div class="mb-3">
                          <label for="addEmail" class="form-label">Email FEMM</label>
                          <input type="email" class="form-control" id="addEmail" required>
                        </div>
                        <div class="mb-3">
                          <label for="addRole" class="form-label">Role</label>
                          <input type="text" class="form-control" id="addRole" required>
                        </div>
                        <div class="mb-3">
                          <label for="addConnection" class="form-label">Last Connection</label>
                          <input type="text" class="form-control" id="addConnection" required>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="addRowButton">Add Employee</button>
                    </div>
                  </div>
                </div>
              </div>

                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Phone</th>
                    <th>Function</th>
                    <th>Email FEMM</th>
                    <th>Role</th>
                    <th>Last Connection</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Phone</th>
                    <th>Function</th>
                    <th>Email FEMM</th>
                    <th>Role</th>
                    <th>Last Connection</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($users as $user)
                  <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->employee_name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->function }}</td>
                    <td>{{ $user->email_femm }}</td>
                    <td>
                        @if($user->role_id === 3)
                            Sef departament
                        @elseif($user->role_id === 4)
                            Angajat
                        @else
                            {{ $user->role->name ?? 'N/A' }}
                        @endif
                    </td>
                    <td>trebuie creata o noua coloana in tabela users pentru a vedea daca userul este sau nu conectat</td>
                    <td>
                      <div class="form-button-action">
                        <button
                          type="button"
                          data-bs-toggle="tooltip"
                          title="Edit Task"
                          class="btn btn-link btn-primary btn-lg"
                        >
                          <i class="fa fa-edit"></i>
                        </button>
                        <button
                          type="button"
                          data-bs-toggle="tooltip"
                          title="Remove"
                          class="btn btn-link btn-danger"
                        >
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
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


<script>

    $(document).ready(function () {
        // Inițializarea DataTable pentru tabelul cu ID-ul add-row
        var table = $("#add-row").DataTable({
          pageLength: 5,
        });

        // Definirea acțiunilor pentru butoanele din fiecare rând
        var action =
          '<td><div class="form-button-action">' +
          '<button type="button" data-bs-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg">' +
          '<i class="fa fa-edit"></i></button>' +
          '<button type="button" data-bs-toggle="tooltip" title="Remove" class="btn btn-link btn-danger">' +
          '<i class="fa fa-times"></i></button>' +
          '</div></td>';

        // La click pe butonul de adăugare a unui rând
        $("#addRowButton").click(function () {
          // Preluarea valorilor din formular
          var name = $("#addName").val();
          var phone = $("#addPhone").val();
          var functionVal = $("#addFunction").val();
          var email = $("#addEmail").val();
          var role = $("#addRole").val();
          var connection = $("#addConnection").val();

          // Adăugarea unui rând nou în DataTable
          table.row.add([
            name,
            phone,
            functionVal,
            email,
            role,
            connection,
            action,
          ]).draw();

          // Închiderea modalului după adăugare
          $("#addRowModal").modal("hide");

          // Resetarea formularului
          $("#addEmployeeForm")[0].reset();
        });
      });

</script>
@endsection
