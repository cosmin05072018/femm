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

        <!-- Main Content -->
        <div id="content">
            <!-- Chat HM + sefi departamente -->
            @if ($existsChatGroup)
                <a href="{{ route('chat.index') }}" class="btn btn-primary">🔵 Mergi la Chat</a>
                <small>In acest grup fac parte Managerul Hotelului si Sefii Departamentelor</small>
                <a href="#">Mergi catre Chat</a>
            @else
                <a href="{{ route('chat.create') }}" class="btn btn-success">➕ Creează un Chat</a>
                <p>Nu există un chat pentru acest hotel. Creează unul acum!</p>
                <a href="#">Creează Chat</a>
            @endif
            <h1></h1>
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
