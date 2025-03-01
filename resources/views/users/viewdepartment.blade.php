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
                    <td>{{ $user->last_connection ?? 'Never' }}</td> <!-- Adăugat coloana Last Connection -->
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

$(document).ready(function () {
    // Inițializarea DataTable pentru tabelul cu ID-ul add-row
    $("#add-row").DataTable({
      pageLength: 5,
      initComplete: function () {
        // Inițializarea filtrelor pe coloane, dacă este necesar
        this.api()
          .columns()
          .every(function () {
            var column = this;
            var select = $(
              '<select class="form-select"><option value=""></option></select>'
            )
              .appendTo($(column.footer()).empty())
              .on("change", function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? "^" + val + "$" : "", true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + d + '">' + d + "</option>");
              });
          });
      },
    });

    // Logica pentru adăugarea unui rând nou
    var action =
      '<td><div class="form-button-action">' +
      '<button type="button" data-bs-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary btn-lg">' +
      '<i class="fa fa-edit"></i></button>' +
      '<button type="button" data-bs-toggle="tooltip" title="Remove" class="btn btn-link btn-danger">' +
      '<i class="fa fa-times"></i></button>' +
      '</div></td>';

    $("#addRowButton").click(function () {
      var userName = $("#addName").val();
      var userPhone = $("#addPhone").val();
      var userFunction = $("#addFunction").val();
      var userEmail = $("#addEmail").val();
      var userRole = $("#addRole").val();
      var userConnection = $("#addConnection").val(); // Adăugăm logică pentru connection

      // Adăugăm rândul nou în tabel
      $("#add-row")
        .DataTable()
        .row.add([
          userName,
          userPhone,
          userFunction,
          userEmail,
          userRole,
          userConnection, // Coloana de Last Connection
          action,
        ])
        .draw();

      // Ascundem modalul de adăugare a rândului
      $("#addRowModal").modal("hide");
    });
  });

@endsection


