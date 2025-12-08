@extends('layouts.app')

@section('title', 'Activities')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Activities</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Activities</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Riwayat Aktivitas</h4>
                        </div>
                        <div class="card-body">
                            <!-- Filter Tabs -->
                            <ul class="nav nav-pills mb-4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#all">Semua</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#products">Produk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#orders">Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#login">Login</a>
                                </li>
                            </ul>

                            <!-- Activities List -->
                            <div class="activities">
                                <div class="activity">
                                    <div class="activity-icon bg-primary text-white shadow-primary">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">2 jam yang lalu</span>
                                        </div>
                                        <p><strong>Membuat produk baru</strong></p>
                                        <p>Anda menambahkan produk "Laptop Asus ROG"</p>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon bg-success text-white shadow-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">5 jam yang lalu</span>
                                        </div>
                                        <p><strong>Order diproses</strong></p>
                                        <p>Order #12345 telah diproses</p>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon bg-purple text-white" style="box-shadow: 0 2px 6px #9c27b0;">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">1 hari yang lalu</span>
                                        </div>
                                        <p><strong>Order baru dibuat</strong></p>
                                        <p>Order baru #12344 senilai Rp 5.000.000</p>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon bg-warning text-white shadow-warning">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">2 hari yang lalu</span>
                                        </div>
                                        <p><strong>Mengupdate produk</strong></p>
                                        <p>Perubahan harga produk "Mouse Gaming"</p>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon bg-info text-white shadow-info">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">3 hari yang lalu</span>
                                        </div>
                                        <p><strong>Login ke sistem</strong></p>
                                        <p>Login dari IP 192.168.1.1</p>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon bg-danger text-white shadow-danger">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">4 hari yang lalu</span>
                                        </div>
                                        <p><strong>Menghapus produk</strong></p>
                                        <p>Produk "Keyboard Bekas" telah dihapus</p>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon bg-secondary text-white shadow-secondary">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">5 hari yang lalu</span>
                                        </div>
                                        <p><strong>Update stok produk</strong></p>
                                        <p>Stok "Monitor LED 24 inch" ditambahkan 10 unit</p>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon bg-primary text-white shadow-primary">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">1 minggu yang lalu</span>
                                        </div>
                                        <p><strong>User baru terdaftar</strong></p>
                                        <p>User baru "John Doe" telah mendaftar</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Load More Button -->
                            <div class="text-center mt-4">
                                <button class="btn btn-primary">
                                    <i class="fas fa-sync-alt"></i> Muat Lebih Banyak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection