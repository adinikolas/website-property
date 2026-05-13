@extends('admin.layouts.app')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    /* HEADER: Mengikuti layout Data Property */
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

    /* LIST CONTAINER */
    .list-container { display: flex; flex-direction: column; gap: 20px; }

    .testi-card {
        background-color: #ebebeb;
        border-radius: 12px;
        padding: 25px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    .testi-card:hover { transform: translateX(8px); }

    /* 1. Foto Profil (Tetap 1:1) */
    .testi-img-wrapper {
        width: 135px;
        height: 135px; /* Kunci 1:1 */
        border-radius: 10px;
        background: #d6d6d6;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #ccc;
    }
    .testi-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    /* 2. Info Testimoni (Tengah) */
    .testi-info { flex-grow: 1; display: flex; flex-direction: column; justify-content: center; }
    .testi-name { font-size: 24px; font-weight: 800; color: #222; margin-bottom: 8px; }

    .prof-badge {
        background-color: #e3f2fd;
        color: #0d6efd;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        width: fit-content;
    }

    .testi-msg {
        font-size: 15px;
        color: #555;
        line-height: 1.6;
        text-align: justify;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* 3. Tombol Aksi (Kanan Vertikal) */
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 140px;
        flex-shrink: 0;
    }
    .btn-p {
        width: 100%;
        padding: 11px 15px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        text-decoration: none;
        border: none;
        outline: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: 0.2s;
    }
    .bg-detail { background: #0d6efd; } .bg-detail:hover { background: #0b5ed7; }
    .bg-edit { background: #f39c12; } .bg-edit:hover { background: #d68910; }
    .bg-delete { background: #e74c3c; } .bg-delete:hover { background: #c0392b; }

    /* === MEDIA QUERIES (IDENTIK DENGAN PROPERTY) === */
    @media (max-width: 768px) {
        .testi-card {
            flex-direction: column;
            padding: 15px;
            gap: 15px;
        }
        .testi-card:hover { transform: translateY(-5px); }
        .testi-img-wrapper { width: 120px; height: 120px; } /* Tetap 1:1 */

        .testi-info { text-align: center; align-items: center; }
        .prof-badge { margin-left: auto; margin-right: auto; }
        .testi-msg { margin-bottom: 10px; -webkit-line-clamp: unset; }

        /* Tombol aksi jadi berjejer 3 kolom horizontal */
        .btn-group {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            width: 100%;
        }
        .btn-p { padding: 10px 5px; font-size: 12px; }
    }

    @media (max-width: 480px) {
        .page-container { padding: 15px; }

        /* HEADER: Menyamakan jarak & ukuran teks */
        .header-flex {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
            gap: 15px; /* Sesuaikan gap dengan CSS Property mu */
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 24px; /* Samakan dengan Property */
            font-weight: 800;
            text-align: center;
            width: 100%;
        }

        .btn-add {
            justify-content: center;
            padding: 12px 20px; /* Padding tombol disamakan */
        }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Testimoni</h1>
        <a href="{{ route('testimonial.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i> Tambah Testimoni
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-check-circle" style="margin-right: 5px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="list-container">
        @forelse($testimonials as $item)
            <div class="testi-card">
                <div class="testi-img-wrapper">
                    @if($item->photo)
                        <img src="{{ asset('storage/' . $item->photo) }}">
                    @else
                        <i class="fa-solid fa-user fa-3x" style="opacity: 0.2;"></i>
                    @endif
                </div>

                <div class="testi-info">
                    <div class="testi-name">{{ $item->name }}</div>
                    <div class="prof-badge">
                        <i class="fa-solid fa-user-tie"></i> Profesi: {{ $item->profesi }}
                    </div>
                    <div class="testi-msg">{{ $item->message }}</div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('testimonial.show', $item->id) }}" class="btn-p bg-detail">
                        <i class="fa-solid fa-eye"></i> Detail
                    </a>
                    <a href="{{ route('testimonial.edit', $item->id) }}" class="btn-p bg-edit">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form action="{{ route('testimonial.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')" style="display: inline-block; margin: 0; width: 100%;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-p bg-delete" style="width: 100%;">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 50px; background: #ebebeb; border-radius: 12px; color: #777;">
                <i class="fa-regular fa-folder-open fa-3x" style="margin-bottom: 15px; opacity: 0.5;"></i>
                <p style="font-size: 16px; font-weight: 600;">Belum ada data testimoni.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
