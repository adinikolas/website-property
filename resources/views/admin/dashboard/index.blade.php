@extends('admin.layouts.app')

@section('content')
<style>
    .dashboard-container {
        padding: 30px;
        background-color: #ffffff;
    }

    /* Judul & Greeting */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap; /* Agar tulisan Hello Admin turun jika layar sangat sempit */
        gap: 10px;
    }
    .dashboard-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }
    .dashboard-greeting { font-size: 14px; color: #666; }

    /* Statistik - Menggunakan CSS Grid yang Responsif */
    .stat-grid {
        display: grid;
        /* Default Desktop: 4 kolom sama besar */
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }
    .stat-card {
        background-color: #f0f0f0;
        border-radius: 12px;
        padding: 25px 15px;
        text-align: center;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-title { font-size: 13px; font-weight: 600; color: #555; margin-bottom: 10px; text-transform: uppercase; }
    .stat-value { font-size: 28px; font-weight: 900; color: #111; }

    /* Bagian Type Unggulan */
    .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #333; }

    .featured-wrapper {
        background-color: #f0f0f0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 40px;
    }

    .featured-flex {
        display: flex;
        gap: 20px;
        flex-wrap: wrap; /* Ini kunci utama agar item turun ke bawah saat layar sempit */
    }

    .featured-card {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        width: calc(25% - 15px); /* 4 kartu per baris di desktop */
        min-width: 200px; /* Lebar minimum agar kartu tidak terlalu gepeng */
        text-align: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    /* Quick Actions */
    .actions-flex {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .btn-action {
        background-color: #31743a;
        color: #fff;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        flex: 1; /* Membuat tombol mengisi ruang yang ada */
        text-align: center;
        min-width: 160px;
    }

    /* === MEDIA QUERIES UNTUK RESPONSIVE === */

    /* Layar Tablet (Max 1024px) */
    @media (max-width: 1024px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 kolom di tablet */
        }
        .featured-card {
            width: calc(50% - 10px); /* 2 kartu per baris di tablet */
        }
    }

    /* Layar HP (Max 600px) */
    @media (max-width: 600px) {
        .dashboard-container { padding: 20px; }
        .stat-grid {
            grid-template-columns: 1fr; /* 1 kolom saja di HP */
        }
        .featured-card {
            width: 100%; /* Kartu memenuhi lebar layar di HP */
        }
        .dashboard-title { font-size: 20px; }
        .btn-action { width: 100%; flex: none; } /* Tombol jadi full width stack ke bawah */
    }
</style>

<div class="dashboard-container">

    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard Admin</h1>
        <span class="dashboard-greeting">Selamat datang kembali, Admin!</span>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-title">Total Property</div>
            <div class="stat-value">{{ $totalProperty }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Type Rumah</div>
            <div class="stat-value">{{ $totalPropertyType }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Total Gambar</div>
            <div class="stat-value">{{ $totalGambar }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Testimoni</div>
            <div class="stat-value">{{ $totalTestimonial }}</div>
        </div>
    </div>

    <h2 class="section-title">Type Unggulan Saat Ini</h2>
    <div class="featured-wrapper">
        <div class="featured-flex">
            @forelse($featuredTypes as $type)
                <div class="featured-card">
                    @if($type->primaryImage)
                        <div style="height: 120px; margin-bottom: 15px;">
                            <img src="{{ asset('storage/' . $type->primaryImage->image_path) }}"
                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                        </div>
                    @else
                        <div style="height: 120px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <i class="fa-solid fa-image fa-2x" style="opacity: 0.2;"></i>
                        </div>
                    @endif
                    <div style="font-weight: 700; font-size: 15px;">Type {{ $type->name_type }}</div>
                    <div style="font-size: 12px; color: #777; margin: 5px 0 10px;">{{ $type->property->name_property }}</div>
                    <div style="font-weight: 800; color: #31743a;">Rp {{ number_format($type->harga_jual, 0, ',', '.') }}</div>
                </div>
            @empty
                <p style="font-size: 14px; color: #888;">Belum ada data unggulan.</p>
            @endforelse
        </div>
    </div>

    <h2 class="section-title">Quick Actions</h2>
    <div class="actions-flex">
        <a href="{{ url('/admin/property/create') }}" class="btn-action">
            <i class="fa-solid fa-plus"></i> Tambah Property
        </a>
        <a href="{{ url('/admin/property_type/create') }}" class="btn-action">
            <i class="fa-solid fa-house-medical"></i> Tambah Type
        </a>
        <a href="{{ url('/admin/property_type_image/create') }}" class="btn-action">
            <i class="fa-solid fa-upload"></i> Upload Gambar
        </a>
    </div>

</div>
@endsection
