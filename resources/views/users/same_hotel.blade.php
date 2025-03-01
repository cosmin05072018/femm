@extends('layouts.userslayout')

@section('title', 'Departamente')

@section('content-users')
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
        <!-- Chat HM + sefi departamente -->
        <div class="container mt-5">
            <div class="card shadow-lg border-0 p-4 text-center">
                <h4 class="mb-3">Chat pentru Hotel</h4>

                @if ($existsChatGroup)
                    <div class="chat-section">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-primary btn-lg d-flex align-items-center gap-2">
                                <span>&#128994;</span> Mergi la Chat
                            </a>
                        </div>
                        <small class="text-muted d-block mt-2">În acest grup fac parte Managerul Hotelului și Șefii
                            Departamentelor.</small>
                    </div>
                @else
                    <div class="chat-section mt-3">
                        <p class="mt-2 text-muted">Nu există un chat pentru acest hotel. Creează unul acum!</p>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-success btn-lg d-flex align-items-center gap-2">
                                <span>&#10133;</span> Creează un Chat
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Main Content -->
        <div id="content">
            <section class="bg-light p-3 shadow-sm">
                @if ($authUser->role_id == 2)
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                            <div class="card w-100 text-center bg-dark text-white">
                                <div class="card-body d-flex flex-column">
                                    <h1 class="card-title text-white py-5">GM</h1>
                                    <a href="#" class="text-white">Vezi mai multe</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row justify-content-center">
                    @foreach ($departments as $department)
                        <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                            <div class="card w-100 text-center position-relative shadow-lg rounded-3 overflow-hidden">
                                <div class="position-absolute top-0 end-0 m-2 text-white d-flex align-items-center p-3">
                                    <i class="fas fa-user me-1"></i> {{ $department->users_count }}
                                </div>
                                <div class="card-body d-flex flex-column py-4"
                                    style="background: {{ $department->color ?? '#3d5272' }};">
                                    <h3 class="card-title text-white my-3">{{ $department->name }}</h3>
                                    <p class="card-text text-white flex-grow-1">{{ $department->description }}</p>
                                    <a href="{{ route('admin.department.users', ['departmentId' => $department->id]) }}"
                                        class="btn btn-light mt-auto rounded-pill">Vezi mai multe</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
