@extends('layouts.layout')

@section('title', 'Hoteluri')

@section('content')
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
            <div class="py-5">
                <h1>DHoteluri</h1>
                <div class="row mt-3">
                    @foreach ($departments as $department)
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card card-custom shadow h-100 py-2"
                                style="background: {{ isset($department['color']) ? $department['color'] : '#3d5272' }};"
                                onmouseover="showColorPicker()" onmouseout="hideColorPicker()">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col d-flex flex-column">
                                            <div
                                                class="d-flex justify-content-center font-weight-bold text-white text-uppercase mb-1">
                                                {{ $department['name'] }}
                                            </div>
                                            <div
                                                class="mt-5 d-flex justify-content-center align-items-center color-picker-container">
                                                <form action="{{ route('admin.change-color') }}" method="POST"
                                                    class="d-flex align-items-center justify-content-center w-100">
                                                    @csrf
                                                    <input type="hidden" name="department_id"
                                                        value="{{ $department['id'] }}">
                                                    <div style="position: relative; width: 50%;">
                                                        <input name="color" class="w-100" type="color" id="colorInput"
                                                            value="{{ isset($department['color']) ? $department['color'] : '#3d5272' }}"
                                                            style="width: 100%; height: 40px; padding: 0; border: none;">
                                                        <span id="colorValue"
                                                            style="position: absolute; top: 0; left: 10px; color: white; line-height: 40px; pointer-events: none;">
                                                            {{ isset($department['color']) ? $department['color'] : '#3d5272' }}
                                                        </span>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-primary ml-2"><i
                                                            class="fas fa-check"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
