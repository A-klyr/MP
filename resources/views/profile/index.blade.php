@extends('layouts.app')

@section('title', 'Profile')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Profile</h1>
            <p class="text-gray-600 mt-2">Kelola informasi profil Anda</p>
        </div>

        <!-- Profile Information Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Informasi Profil</h2>
            
            <form action="{{ route('user-profile-information.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Avatar -->
                <div class="flex items-center mb-6">
                    <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center text-2xl font-bold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Informasi Akun</h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Member sejak</span>
                    <span class="font-medium">{{ Auth::user()->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Status Akun</span>
                    <span class="font-medium text-green-600">Aktif</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">ID Pengguna</span>
                    <span class="font-medium">#{{ Auth::user()->id }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection