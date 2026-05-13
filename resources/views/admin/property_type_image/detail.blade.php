@extends('admin.layouts.app')

@section('title', 'Detail Gambar Property')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    /* Header & Tombol Kembali (Desktop) */
    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    .btn-back { padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; background-color: #6c757d; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-back:hover { background-color: #5a6268; }

    /* Card Utama: Warna abu-abu (#ebebeb) */
    .detail-card { background: #ebebeb; border-radius: 12px; padding: 40px; width: 100%; margin-bottom: 30px; }

    .data-group { margin-bottom: 30px; }

    /* Styling Teks Sesuai Detail Property */
    .data-label { font-size: 12px; font-weight: 800; color: #888; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    .data-value { font-size: 24px; font-weight: 800; color: #222; line-height: 1.3; }

    /* Grid Khusus Detail Gambar (Diberi jarak yang pas) */
    .images-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 35px; margin-top: 15px; }

    .img-item { display: flex; flex-direction: column; gap: 12px; }
    .img-box { background: #d6d6d6; border-radius: 8px; overflow: hidden; aspect-ratio: 16 / 9; display: flex; align-items: center; justify-content: center; border: 1px solid #ccc; }
    .img-box img { width: 100%; height: 100%; object-fit: contain; }
    .img-caption { text-align: center; font-size: 15px; font-weight: 800; color: #444; }

    /* Tombol Aksi Bawah (Rata Kanan dengan Garis Pembatas) */
    .bottom-actions {
        display: flex;
        justify-content: flex-end; /* Tombol pindah ke kanan */
        gap: 15px;
        margin-top: 40px;
        padding-top: 25px; /* Jarak antara garis dengan tombol */
        border-top: 1px solid #ccc; /* Garis pembatas sesuai gambar */
        flex-wrap: wrap;
    }

    .btn-act { padding: 12px 25px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; color: #fff; cursor: pointer; border: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: 0.2s; }

    .bg-edit { background: #f39c12; } .bg-edit:hover { background: #d68910; }
    .bg-delete { background: #e74c3c; } .bg-delete:hover { background: #c0392b; }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .page-container { padding: 15px; }
        .detail-card { padding: 25px; }

        /* Penyesuaian Mobile: Judul rata tengah, tombol kembali di bawah judul */
        .header-flex { flex-direction: column; align-items: stretch; text-align: center; gap: 15px; }
        .btn-back { width: 100%; justify-content: center; }

        .images-grid { grid-template-columns: 1fr; gap: 25px; }

        /* Tombol aksi jadi memanjang dan bertumpuk di layar HP */
        .bottom-actions { flex-direction: column; align-items: stretch; }
        .bottom-actions form { width: 100%; margin: 0; display: flex; } /* Memastikan form ikut full-width */
        .btn-act { width: 100%; }
    }
</style>

<div class="page-container">
    <!-- Header Section -->
    <div class="header-flex">
        <h1 class="page-title">Detail Gambar Property</h1>
        <a href="{{ route('property_type_image.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Detail Card Section -->
    <div class="detail-card">

        <div class="data-group">
            <div class="data-label">Nama Type Rumah</div>
            <div class="data-value">Type {{ $type->name_type }} - {{ $type->property->name_property ?? '' }}</div>
        </div>

        <div class="data-group">
            <div class="data-label">Gambar Property</div>
            <div class="images-grid">
                @foreach($type->images as $index => $img)
                    <div class="img-item">
                        <div class="img-box">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Gambar {{ $index + 1 }}">
                        </div>
                        <div class="img-caption">Gambar {{ $index + 1 }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tombol Aksi (Edit & Hapus) -->
        <div class="bottom-actions">
            <a href="{{ route('property_type_image.edit', $type->id) }}" class="btn-act bg-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data
            </a>
            <form action="{{ route('property_type_image.destroy', $type->id) }}" method="POST" style="margin: 0; display: flex;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-act bg-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus SEMUA gambar untuk Type ini?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Data
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
