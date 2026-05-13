@extends('admin.layouts.app')

@section('title', 'Detail Property')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    .btn-back { padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; background-color: #6c757d; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-back:hover { background-color: #5a6268; }

    .main-property-card { background: #ebebeb; border-radius: 12px; padding: 40px; width: 100%; margin-bottom: 30px; }

    .property-detail-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start; }

    .image-column { width: 100%; }
    .large-gambar-box {
        width: 100%; aspect-ratio: 16 / 9; background: #d6d6d6; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
    }

    .large-gambar-box img { width: 100%; height: 100%; object-fit: contain; }

    .text-column { display: flex; flex-direction: column; gap: 20px; height: 100%; justify-content: space-between; }
    .data-group { margin-bottom: 15px; }

    .data-label { font-size: 12px; font-weight: 800; color: #888; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
    .data-value { font-size: 24px; font-weight: 800; color: #222; line-height: 1.3; }
    .data-desc { font-size: 15px; color: #444; line-height: 1.6; text-align: justify; }

    .inline-actions { display: flex; gap: 10px; margin-top: auto; padding-top: 10px; }
    .btn-act { padding: 12px 25px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; color: #fff; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }

    .bg-edit { background: #f39c12; color: #fff; }
    .bg-edit:hover { background: #d68910; }
    .bg-delete { background: #e74c3c; }
    .bg-delete:hover { background: #c0392b; }

    .types-section-card { background: #ebebeb; border-radius: 12px; padding: 30px; }

    .types-header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .section-title { font-size: 20px; font-weight: 800; color: #222; margin: 0; }

    .btn-tambah-type { background: #31743a; color: #fff; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; }
    .btn-tambah-type:hover { background: #24582a; }

    .types-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px; }

    .type-card {
        background: #fff; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #ddd; overflow: hidden; position: relative;
    }
    .type-card-content { padding: 20px; padding-left: 25px; }
    .type-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background-color: #31743a; }

    .type-name { font-size: 16px; font-weight: 800; color: #222; margin-bottom: 5px; }
    .type-price { font-size: 14px; font-weight: 800; color: #2e7d32; margin-bottom: 8px; }
    .type-info { font-size: 12px; color: #777; font-weight: 600; }

    .manage-all-link { text-align: center; margin-top: 25px; }
    .manage-all-link a { font-size: 14px; font-weight: 700; color: #0d6efd; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .manage-all-link a:hover { text-decoration: underline; }

    /* Mobile Responsive - Diperbaiki bagian inline-actions */
    @media (max-width: 991px) {
        .property-detail-layout { grid-template-columns: 1fr; gap: 30px; }

        /* Ubah jadi column agar menumpuk rapi */
        .inline-actions { flex-direction: column; margin-top: 15px; }
        /* Pastikan form pembungkus tombol hapus ikut 100% */
        .inline-actions form { width: 100%; }

        .btn-act { width: 100%; justify-content: center; }
    }
    @media (max-width: 768px) {
        .page-container { padding: 15px; }
        .main-property-card, .types-section-card { padding: 20px; }
        .header-flex, .types-header-flex { flex-direction: column; align-items: stretch; text-align: center; gap: 15px; }
        .btn-back, .btn-tambah-type { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Detail Property</h1>
        <a href="{{ route('property.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar</a>
    </div>

    <div class="main-property-card">
        <div class="property-detail-layout">
            <div class="image-column">
                <div class="large-gambar-box">
                    @if($property->image)
                        <img src="{{ asset('storage/' . $property->image) }}" alt="Gambar Properti">
                    @else
                        <div style="text-align: center;">
                            <i class="fa-regular fa-image fa-4x" style="opacity: 0.2;"></i>
                            <div style="font-size: 12px; color: #888; margin-top: 10px;">(Belum ada gambar)</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-column">
                <div class="top-text-area">
                    <div class="data-group">
                        <div class="data-label">NAMA PERUMAHAN</div>
                        <div class="data-value">{{ $property->name_property }}</div>
                    </div>

                    <div class="data-group">
                        <div class="data-label">KETERANGAN</div>
                        <div class="data-desc">{{ $property->description }}</div>
                    </div>
                </div>

                <div class="inline-actions">
                    <a href="{{ route('property.edit', $property->id) }}" class="btn-act bg-edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Data
                    </a>
                    <form action="{{ route('property.destroy', $property->id) }}" method="POST" style="margin: 0; display:flex;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-act bg-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus Property ini?')">
                            <i class="fa-solid fa-trash-can"></i> Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="types-section-card">
        <div class="types-header-flex">
            <h2 class="section-title">Daftar Type Rumah</h2>
            <a href="{{ route('property_type.create', ['property_id' => $property->id]) }}" class="btn-tambah-type">
                <i class="fa-solid fa-plus"></i> Tambah Type
            </a>
        </div>

        <div class="types-list">
            <div class="type-card">
                <div class="type-card-content">
                    <div class="type-name">Type 35/60</div>
                    <div class="type-price">Rp 166.000.000</div>
                    <div class="type-info">Subsidi • 2 Kamar</div>
                </div>
            </div>
        </div>

        <div class="manage-all-link">
            <a href="{{ route('property_type.index', ['property_id' => $property->id]) }}">
                Lihat & Kelola Selengkapnya <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

</div>
@endsection
