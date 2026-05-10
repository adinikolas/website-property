@extends('admin.layouts.app')

@section('content')
<style>
    .page-container {
        padding: 30px;
        background-color: #ffffff;
        min-height: 100vh;
    }

    /* Header (Desktop: Normal/Kiri-Kanan) */
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 800;
        color: #222;
        margin: 0;
    }

    /* --- DETAIL CARD STYLES --- */
    .detail-card {
        background-color: #ebebeb;
        border-radius: 12px;
        padding: 25px;
        display: flex;
        flex-direction: row;
        gap: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    /* Bagian Gambar */
    .detail-img-wrapper {
        width: 45%;
        background-color: #ffffff;
        padding: 15px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
    }

    .detail-img-wrapper img {
        width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: cover;
        border-radius: 6px;
    }

    /* Bagian Konten Informasi */
    .detail-info {
        width: 55%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .info-label {
        font-size: 12px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .prop-name {
        font-size: 26px;
        font-weight: 800;
        color: #222;
        margin-bottom: 20px;
    }

    .prop-desc {
        font-size: 15px;
        color: #555;
        line-height: 1.7;
        margin-bottom: 30px;
    }

    /* --- SECTION TYPE RUMAH (OVERVIEW) --- */
    .type-section {
        background-color: #f9f9f9;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #eee;
    }

    .type-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .type-item {
        background: #ffffff;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #31743a;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    /* Tombol Aksi */
    .detail-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: auto;
    }

    .btn-d {
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 700;
        text-decoration: none;
        color: #fff;
        border: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .bg-manage { background-color: #31743a; }
    .bg-back { background-color: #6c757d; }
    .bg-edit { background-color: #f39c12; }
    .bg-delete { background-color: #e74c3c; }

    /* === MEDIA QUERIES === */
    @media (max-width: 992px) {
        .detail-card { flex-direction: column; padding: 20px; }
        .detail-img-wrapper, .detail-info { width: 100%; }
        .detail-img-wrapper img { max-height: 300px; }
    }

    /* Layar Mobile */
    @media (max-width: 600px) {
        .page-container { padding: 15px; }

        /* Header Rata Tengah di Mobile */
        .header-flex {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .detail-actions { flex-direction: column; }
        .btn-d { width: 100%; justify-content: center; }

        /* Judul Section Type Rumah ke tengah di Mobile */
        .type-header-mobile { flex-direction: column; text-align: center; }
    }
</style>

<div class="page-container">

    <div class="header-flex">
        <h1 class="page-title">Detail Property</h1>
        <a href="{{ route('property.index') }}" class="btn-d bg-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="detail-card">
        <div class="detail-img-wrapper">
            @if($property->image)
                <img src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->name_property }}">
            @else
                <div style="text-align: center; color: #bbb;">
                    <i class="fa-regular fa-image fa-4x"></i>
                    <p style="margin-top: 10px; font-size: 12px;">Tidak ada gambar</p>
                </div>
            @endif
        </div>

        <div class="detail-info">
            <div class="info-label">Nama Perumahan</div>
            <div class="prop-name">{{ $property->name_property }}</div>

            <div class="info-label">Keterangan</div>
            <div class="prop-desc">{{ $property->description }}</div>

            <div class="detail-actions">
                <a href="{{ route('property.edit', $property->id) }}" class="btn-d bg-edit">
                    <i class="fa-solid fa-pen"></i> Edit Data
                </a>

                <form action="{{ route('property.destroy', $property->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Hapus property ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-d bg-delete">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="type-section">
        <div class="header-flex type-header-mobile" style="margin-bottom: 0;">
            <h3 style="font-weight: 800; color: #222; margin: 0;">Daftar Type Rumah</h3>

            <a href="{{ url('admin/property_type/create?property_id=' . $property->id) }}" class="btn-d bg-manage">
                <i class="fa-solid fa-plus"></i> Tambah Type
            </a>
        </div>

        @if($property->propertyTypes->count() > 0)
            <div class="type-grid">
                @foreach($property->propertyTypes as $type)
                    <div class="type-item">
                        <div style="font-weight: 800; font-size: 16px;">Type {{ $type->name_type }}</div>
                        <div style="color: #31743a; font-weight: 700; font-size: 14px; margin: 5px 0;">
                            Rp {{ number_format($type->harga_jual, 0, ',', '.') }}
                        </div>
                        <div style="font-size: 12px; color: #777;">
                            {{ $type->jenis_type }} • {{ $type->jml_kamar }} Kamar
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 20px; text-align: center;">
                <a href="{{ url('admin/property_type?property_id=' . $property->id) }}" style="font-size: 13px; font-weight: 600; color: #007bff; text-decoration: none;">
                    Lihat & Kelola Selengkapnya <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i>
                </a>
            </div>

        @else
            <div style="margin-top: 20px; padding: 20px; text-align: center; background: #fff; border-radius: 8px; color: #999; font-size: 14px; border: 1px dashed #ccc;">
                <i class="fa-solid fa-house-chimney-window fa-2x" style="margin-bottom: 10px; opacity: 0.3;"></i>
                <p>Belum ada tipe rumah yang ditambahkan.</p>
            </div>
        @endif
    </div>
</div>
@endsection
