@extends('admin.layouts.app')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    .btn-add { background: #31743a; color: #fff; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; border: none; }
    .btn-add:hover { background: #24582a; }

    /* Grid Kartu Gallery */
    .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 30px; }

    /* Card disesuaikan: Background abu-abu (#ebebeb), dengan efek shadow */
    .gallery-card {
        background: #ebebeb;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    /* Background gambar dibuat lebih gelap dari kotak agar kontras */
    .img-wrapper { width: 100%; aspect-ratio: 4 / 3; background: #d6d6d6; border-radius: 8px; overflow: hidden; margin-bottom: 15px; position: relative; }
    .img-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .badge-count { position: absolute; top: 10px; left: 10px; background: #31743a; color: #fff; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 800; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }

    .card-title { font-size: 18px; font-weight: 800; color: #222; margin-bottom: 5px; }
    .card-subtitle { font-size: 14px; font-weight: 600; color: #777; margin-bottom: 25px; }

    .card-actions { display: flex; flex-direction: column; gap: 10px; margin-top: auto; }
    .btn-act { padding: 10px; border-radius: 6px; font-size: 14px; font-weight: 700; color: #fff; text-decoration: none; border: none; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: 0.2s; }

    .bg-detail { background: #0d6efd; } .bg-detail:hover { background: #0b5ed7; }
    .bg-edit { background: #f39c12; } .bg-edit:hover { background: #d68910; }
    .bg-delete { background: #e74c3c; } .bg-delete:hover { background: #c0392b; }

    /* Alert Sukses */
    .alert-success { background: #d1e7dd; color: #0f5132; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; font-weight: 600; border: 1px solid #badbcc; display: flex; justify-content: space-between; align-items: center; }
    .btn-close-alert { background: none; border: none; font-size: 18px; color: #0f5132; cursor: pointer; }

    @media(max-width: 600px) {
        .page-container { padding: 15px; }
        .gallery-card { padding: 20px; }
        .header-flex { flex-direction: column; text-align: center; }
        .btn-add { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Gambar Property</h1>
        <a href="{{ route('property_type_image.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i> Tambah Gambar Property
        </a>
    </div>

    <!-- Menampilkan Pesan Sukses Jika Ada -->
    @if(session('success'))
        <div class="alert-success" id="success-alert">
            <div><i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}</div>
            <button class="btn-close-alert" onclick="document.getElementById('success-alert').style.display='none'">&times;</button>
        </div>
    @endif

    <div class="gallery-grid">
        @foreach($typesWithImages as $type)
            <div class="gallery-card">
                <div class="img-wrapper">
                    <div class="badge-count">{{ $type->images->count() }} Gambar</div>
                    <!-- Tampilkan gambar pertama sbg cover -->
                    <img src="{{ asset('storage/' . $type->images->first()->image_path) }}" alt="Cover">
                </div>

                <div class="card-title">Type {{ $type->name_type }}</div>
                <div class="card-subtitle">{{ $type->property->name_property ?? '-' }}</div>

                <div class="card-actions">
                    <a href="{{ route('property_type_image.show', $type->id) }}" class="btn-act bg-detail">
                        <i class="fa-solid fa-eye"></i> Detail
                    </a>
                    <a href="{{ route('property_type_image.edit', $type->id) }}" class="btn-act bg-edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <form action="{{ route('property_type_image.destroy', $type->id) }}" method="POST" style="margin: 0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-act bg-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus SEMUA gambar untuk Type ini?')">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
