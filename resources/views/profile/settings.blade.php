@extends('layouts.app')

@section('title', 'Settings')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Settings</div>
            </div>
        </div>

        <div class="section-body">
            <!-- Change Password Card -->
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Ubah Password</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user-password.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label>Password Saat Ini</label>
                                    <input type="password" name="current_password" 
                                        class="form-control @error('current_password') is-invalid @enderror" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" name="password" 
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" 
                                        class="form-control" required>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Two-Factor Authentication -->
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Two-Factor Authentication</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Tingkatkan keamanan akun dengan mengaktifkan autentikasi dua faktor.</p>

                            @if(Auth::user()->two_factor_secret)
                                <div class="alert alert-success">
                                    <div class="alert-title">Aktif</div>
                                    Two-Factor Authentication telah diaktifkan
                                </div>

                                <form action="{{ route('two-factor.disable') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Nonaktifkan 2FA
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('two-factor.enable') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-shield-alt"></i> Aktifkan 2FA
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pengaturan Notifikasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="control-label">Notifikasi Email</div>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="email_notifications" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Terima notifikasi melalui email</span>
                                </label>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Notifikasi Order</div>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="order_notifications" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Notifikasi ketika ada order baru</span>
                                </label>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Update Produk</div>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="product_updates" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Notifikasi perubahan produk</span>
                                </label>
                            </div>

                            <div class="text-right">
                                <button class="btn btn-primary">Simpan Pengaturan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h4>Danger Zone</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Tindakan berikut bersifat permanen dan tidak dapat dibatalkan.</p>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
                                <i class="fas fa-trash"></i> Hapus Akun
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Akun</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger">Ya, Hapus Akun</button>
            </div>
        </div>
    </div>
</div>
@endsection