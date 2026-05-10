@extends('admin.layouts.app')

@section('content')
<style>
    .page-container {
        padding: 30px;
        background-color: #ffffff;
        min-height: 100vh;
    }

    /* Header & Button Tambah */
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    .btn-add {
        background-color: #31743a;
        color: #fff;
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
    .btn-add:hover { background-color: #24582a; }

    .alert-success {
        background-color: #d4edda; color: #155724; padding: 15px;
        border-radius: 8px; margin-bottom: 25px; font-weight: 600; font-size: 14px;
    }

    /* --- LIST VIEW STYLES --- */
    .list-container {
        display: flex; flex-direction: column; gap: 20px;
    }

    .prop-list-card {
        background-color: #ebebeb;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: row; /* Desktop: Kiri ke Kanan */
        align-items: stretch;
        gap: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    .prop-list-card:hover { transform: translateX(8px); }

    /* 1. Gambar (Kiri) */
    .prop-img-wrapper {
        width: 280px; height: 180px; flex-shrink: 0;
        border-radius: 8px; overflow: hidden; background-color: #d6d6d6;
        display: flex; align-items: center; justify-content: center;
    }
    .prop-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    /* 2. Area Teks (Tengah) */
    .prop-info {
        flex-grow: 1; /* Memakan sisa ruang kosong di tengah */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .prop-name { font-size: 22px; font-weight: 800; color: #222; margin-bottom: 10px; }

    .type-indicator {
        display: inline-flex; align-items: center; padding: 6px 12px;
        border-radius: 6px; font-size: 12px; font-weight: 600;
        margin-bottom: 15px; width: fit-content;
    }
    .indicator-filled { background-color: #e3f2fd; color: #0d47a1; }
    .indicator-empty { background-color: #fff3cd; color: #856404; }

    .prop-desc {
        font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 0;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }

    /* 3. Area Tombol (Kanan) */
    .btn-group {
        display: flex;
        flex-direction: column; /* Desktop: Tombol disusun ke bawah */
        justify-content: center;
        gap: 10px;
        min-width: 140px; /* Lebar area tombol di kanan */
        flex-shrink: 0;
    }

    .btn-p {
        padding: 10px 15px; border-radius: 6px; font-size: 13px;
        font-weight: 700; text-decoration: none; color: #fff;
        text-align: center; border: none; cursor: pointer; transition: 0.2s;
        width: 100%; /* Tombol memenuhi lebar containernya */
    }
    .bg-detail { background-color: #007bff; } .bg-detail:hover { background-color: #0056b3; }
    .bg-edit { background-color: #f39c12; } .bg-edit:hover { background-color: #d68910; }
    .bg-delete { background-color: #e74c3c; height: 100%; } .bg-delete:hover { background-color: #c0392b; }

    /* === MEDIA QUERIES UNTUK RESPONSIVE (MOBILE & TABLET) === */
    @media (max-width: 768px) {
        .prop-list-card {
            flex-direction: column; /* Berubah jadi susunan ke bawah */
            padding: 15px; gap: 15px;
        }
        .prop-list-card:hover { transform: translateY(-5px); }
        .prop-img-wrapper { width: 100%; height: 200px; }

        /* Membuat Teks Rata Tengah di Mobile */
        .prop-info {
            text-align: center;
            align-items: center; /* Membuat badge indikator ikut ke tengah */
        }
        .type-indicator {
            margin-left: auto; margin-right: auto; /* Memastikan badge rata tengah */
        }
        .prop-desc { margin-bottom: 10px; }

        /* Mengubah Tombol Jadi Berjejer Horizontal di Mobile */
        .btn-group {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 tombol berjejer rata */
            gap: 8px;
            width: 100%;
        }
        .btn-p { padding: 10px 5px; font-size: 12px; }
    }

    @media (max-width: 480px) {
        .page-container { padding: 15px; }
        .header-flex { flex-direction: column; align-items: stretch; text-align: center; }
        .btn-add { justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Data Property</h1>
        <a href="{{ route('property.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i> Tambah Property
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-check-circle" style="margin-right: 5px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="list-container">
        @forelse($properties as $item)
            <div class="prop-list-card">

                <div class="prop-img-wrapper">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name_property }}">
                    @else
                        <i class="fa-regular fa-image fa-3x" style="opacity: 0.2;"></i>
                    @endif
                </div>

                <div class="prop-info">
                    <div class="prop-name">{{ $item->name_property }}</div>

                    @if($item->property_types_count > 0)
                        <div class="type-indicator indicator-filled">
                            <i class="fa-solid fa-list-ul" style="margin-right: 6px;"></i>
                            Terdapat {{ $item->property_types_count }} type rumah pada property ini
                        </div>
                    @else
                        <div class="type-indicator indicator-empty">
                            <i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i>
                            Belum ada type rumah yang terhubung
                        </div>
                    @endif

                    <div class="prop-desc">{{ $item->description }}</div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('property.show', $item->id) }}" class="btn-p bg-detail">
                        <i class="fa-solid fa-eye" style="margin-right: 4px;"></i> Detail
                    </a>
                    <a href="{{ route('property.edit', $item->id) }}" class="btn-p bg-edit">
                        <i class="fa-solid fa-pen" style="margin-right: 4px;"></i> Edit
                    </a>
                    <form action="{{ route('property.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus property ini?')" style="display: inline-block; margin: 0; width: 100%;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-p bg-delete" style="width: 100%;">
                            <i class="fa-solid fa-trash" style="margin-right: 4px;"></i> Hapus
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div style="text-align: center; padding: 50px; background: #ebebeb; border-radius: 12px; color: #777;">
                <i class="fa-regular fa-folder-open fa-3x" style="margin-bottom: 15px; opacity: 0.5;"></i>
                <p style="font-size: 16px; font-weight: 600;">Belum ada data property.</p>
                <p style="font-size: 14px;">Silakan klik tombol "Tambah Property" untuk memulai.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
