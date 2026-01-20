@extends('layouts.app')

@section('title', 'Edit User')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Advanced Forms</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Users</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Users</h2>



                <div class="card">
                    <form action="{{ route('user.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Input Text</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text"
                                    class="form-control @error('name')
                                is-invalid
                            @enderror"
                                    name="name" value="{{ $user->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email"
                                    class="form-control @error('email')
                                is-invalid
                            @enderror"
                                    name="email" value="{{ $user->email }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password"
                                        class="form-control @error('password')
                                is-invalid
                            @enderror"
                                        name="password">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Roles</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="roles" value="admin" class="selectgroup-input"
                                            @if ($user->roles == 'admin') checked @endif>
                                        <span class="selectgroup-button">Admin</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="roles" value="staff" class="selectgroup-input"
                                            @if ($user->roles == 'staff') checked @endif>
                                        <span class="selectgroup-button">Staff</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="roles" value="user" class="selectgroup-input"
                                            @if ($user->roles == 'user') checked @endif>
                                        <span class="selectgroup-button">User</span>
                                    </label>

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Location</label>
                                <div id="map" style="height: 300px; width: 100%; margin-bottom: 15px;"></div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Latitude</label>
                                        <input type="text" id="latitude" name="latitude" class="form-control" value="{{ $user->latitude }}">
                                    </div>
                                    <div class="col-6">
                                        <label>Longitude</label>
                                        <input type="text" id="longitude" name="longitude" class="form-control" value="{{ $user->longitude }}">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label>Address</label>
                                    <textarea name="address" class="form-control" style="height: 80px;">{{ $user->address }}</textarea>
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    // Default coordinates (Jakarta) or User's coordinates
                                    var lat = {{ $user->latitude ?? -6.2088 }};
                                    var lng = {{ $user->longitude ?? 106.8456 }};
                                    
                                    var map = L.map('map').setView([lat, lng], 13);
                                    
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; OpenStreetMap contributors'
                                    }).addTo(map);

                                    var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

                                    // Update inputs when marker is dragged
                                    marker.on('dragend', function(e) {
                                        var position = marker.getLatLng();
                                        document.getElementById('latitude').value = position.lat;
                                        document.getElementById('longitude').value = position.lng;
                                    });

                                    // Move marker on map click
                                    map.on('click', function(e) {
                                        marker.setLatLng(e.latlng);
                                        document.getElementById('latitude').value = e.latlng.lat;
                                        document.getElementById('longitude').value = e.latlng.lng;
                                    });
                                });
                            </script>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
