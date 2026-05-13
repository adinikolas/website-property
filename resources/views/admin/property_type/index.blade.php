@extends('admin.layouts.app')

@section('title', 'Type Rumah')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }
    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    .btn-add { background-color: #31743a; color: #fff; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-add:hover { background-color: #24582a; }

    .list-container { display: flex; flex-direction: column; gap: 20px; }

    /* --- STYLE KARTU --- */
    .type-card {
        background-color: #ebebeb;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: row;
        align-items: stretch;
        gap: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Animasi Hover Desktop */
    .type-card:hover {
        transform: translateX(8px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }

    /* Gambar Kiri */
    .type-img-wrapper {
        width: 280px; height: 180px; border-radius: 8px; background: #d6d6d6;
        object-fit: cover; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .type-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    /* Konten di tengah */
    .type-info { flex-grow: 1; display: flex; flex-direction: column; justify-content: center; }

    .info-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px; }
    .type-name { font-size: 22px; font-weight: 800; color: #222; margin: 0; }
    .type-jenis { font-size: 12px; font-weight: 800; color: #555; text-transform: uppercase; background: #fff; padding: 4px 10px; border-radius: 6px; border: 1px solid #ddd;}

    .type-prop { font-size: 15px; font-weight: 700; color: #222; margin-bottom: 8px; }
    .type-kamar { font-size: 13px; color: #666; }

    .price-box { text-align: right; margin-top: auto; }
    .price-label { font-size: 11px; color: #777; margin-bottom: 3px; font-weight: 700; text-transform: uppercase; }
    /* Ukuran Harga Disamakan dengan Ukuran Nama Type (22px) */
    .price-value { font-size: 22px; font-weight: 800; color: #2e7d32; }

    /* --- TOMBOL AKSI KANAN --- */
    .btn-group {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
        min-width: 140px;
        flex-shrink: 0;
    }

    .btn-group form {
        margin: 0;
        width: 100%;
        display: flex;
    }

    /* Icon, jarak teks, dan padding disamakan persis dengan Property */
    .btn-p {
        padding: 10px 15px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        color: #fff;
        text-align: center;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        width: 100%;
        transition: 0.2s;
    }

    .bg-detail { background-color: #007bff; } .bg-detail:hover { background-color: #0056b3; transform: translateY(-2px); }
    .bg-edit { background-color: #f39c12; } .bg-edit:hover { background-color: #d68910; transform: translateY(-2px); }
    .bg-delete { background-color: #e74c3c; } .bg-delete:hover { background-color: #c82333; transform: translateY(-2px); }

    /* === MEDIA QUERIES === */
    @media (max-width: 768px) {
        .type-card { flex-direction: column; }
        .type-card:hover { transform: translateY(-5px); }

        .type-img-wrapper { width: 100%; height: 200px; }
        .info-header { align-items: center; }

        /* Memastikan Harga tetap Rata Kanan di Mobile */
        .price-box { text-align: right; margin-top: 15px; margin-bottom: 15px; }

        /* Tombol Mobile: Grid 3 Kolom */
        .btn-group { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; width: 100%; }
        .btn-p { padding: 10px 5px; font-size: 12px; }
    }

    @media (max-width: 600px) {
        .page-container { padding: 15px; }
        .header-flex { flex-direction: column; align-items: stretch; text-align: center; }
        .btn-add { justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Data Type Rumah</h1>
        <a href="{{ route('property_type.create') }}" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Type</a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
            <i class="fa-solid fa-check-circle" style="margin-right: 5px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="list-container">
        @forelse($types as $item)
        <div class="type-card">

            <div class="type-img-wrapper">
                @if($item->primaryImage)
                    <img src="{{ asset('storage/' . $item->primaryImage->image_path) }}" alt="Gambar">
                @else
                    <i class="fa-regular fa-image fa-3x" style="opacity: 0.2;"></i>
                @endif
            </div>

            <div class="type-info">
                <div class="info-header">
                    <div class="type-name">Type {{ $item->name_type }}</div>
                    <div class="type-jenis">{{ $item->jenis_type }}</div>
                </div>

                <div class="type-prop">{{ $item->property->name_property ?? '-' }}</div>
                <div class="type-kamar">{{ $item->jml_kamar }} Kamar</div>

                <div class="price-box">
                    <div class="price-label">Harga jual</div>
                    <div class="price-value">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('property_type.show', $item->id) }}" class="btn-p bg-detail">
                    <i class="fa-solid fa-eye"></i> Detail
                </a>

                <a href="{{ route('property_type.edit', $item->id) }}" class="btn-p bg-edit">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>

                <form action="{{ route('property_type.destroy', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-p bg-delete" onclick="return confirm('Hapus Type Rumah ini?')">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>

        </div>
        @empty
            <div style="text-align: center; padding: 50px; background: #ebebeb; border-radius: 12px; color: #777;">
                <i class="fa-regular fa-folder-open fa-3x" style="margin-bottom: 15px; opacity: 0.5;"></i>
                <p style="font-size: 16px; font-weight: 600;">Belum ada data type rumah.</p>
                <p style="font-size: 14px;">Silakan klik tombol "Tambah Type" untuk memulai.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
