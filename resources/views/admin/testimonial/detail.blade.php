@extends('admin.layouts.app')

@section('title', 'Detail Testimoni')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    .btn-back { padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; background-color: #6c757d; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-back:hover { background-color: #5a6268; }

    .main-testi-card { background: #ebebeb; border-radius: 12px; padding: 40px; width: 100%; margin-bottom: 30px; }

    /* Layout Detail: Grid 2 kolom */
    .testi-detail-layout { display: grid; grid-template-columns: auto 1fr; gap: 40px; align-items: start; }

    .image-column { flex-shrink: 0; }

    /* Foto Profil 1:1 identik dengan gaya Testimoni */
    .testi-gambar-box {
        width: 250px; height: 250px; background: #d6d6d6; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
        border: 1px solid #ccc;
    }
    .testi-gambar-box img { width: 100%; height: 100%; object-fit: cover; }

    .text-column { display: flex; flex-direction: column; gap: 20px; min-height: 250px; justify-content: space-between; }
    .data-group { margin-bottom: 15px; }

    .data-label { font-size: 12px; font-weight: 800; color: #888; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
    .data-value { font-size: 28px; font-weight: 800; color: #222; line-height: 1.2; }

    /* Profesi Badge */
    .prof-badge {
        background-color: #e3f2fd; color: #0d6efd; padding: 6px 14px; border-radius: 6px;
        font-size: 13px; font-weight: 800; display: inline-flex; align-items: center; gap: 8px;
        margin-top: 5px;
    }

    .data-desc { font-size: 16px; color: #444; line-height: 1.7; text-align: justify; font-style: italic; }

    .inline-actions { display: flex; gap: 10px; margin-top: auto; padding-top: 20px; }
    .btn-act { padding: 12px 25px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; color: #fff; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }

    .bg-edit { background: #f39c12; }
    .bg-edit:hover { background: #d68910; }
    .bg-delete { background: #e74c3c; }
    .bg-delete:hover { background: #c0392b; }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .testi-detail-layout { grid-template-columns: 1fr; gap: 30px; text-align: center; justify-items: center; }
        .text-column { align-items: center; min-height: auto; }
        .inline-actions { flex-direction: column; width: 100%; }
        .inline-actions form { width: 100%; }
        .btn-act { width: 100%; justify-content: center; }
        .data-desc { text-align: center; }
    }

    @media (max-width: 768px) {
        .page-container { padding: 15px; }
        .main-testi-card { padding: 25px 20px; }
        .header-flex { flex-direction: column; align-items: stretch; text-align: center; gap: 15px; }
        .btn-back { width: 100%; justify-content: center; }
        .testi-gambar-box { width: 200px; height: 200px; }
        .data-value { font-size: 24px; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Detail Testimoni</h1>
        <a href="{{ route('testimonial.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="main-testi-card">
        <div class="testi-detail-layout">
            <!-- Kolom Foto Profil (1:1) -->
            <div class="image-column">
                <div class="testi-gambar-box">
                    @if($testimonial->photo)
                        <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="Foto {{ $testimonial->name }}">
                    @else
                        <div style="text-align: center;">
                            <i class="fa-solid fa-user fa-5x" style="color: #aaa;"></i>
                            <div style="font-size: 12px; color: #888; margin-top: 15px;">(Tidak ada foto)</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kolom Informasi Teks -->
            <div class="text-column">
                <div class="top-text-area">
                    <div class="data-group">
                        <div class="data-label">NAMA LENGKAP</div>
                        <div class="data-value">{{ $testimonial->name }}</div>
                        <div class="prof-badge">
                            <i class="fa-solid fa-user-tie"></i> Profesi: {{ $testimonial->profesi }}
                        </div>
                    </div>

                    <div class="data-group" style="margin-top: 25px;">
                        <div class="data-label">PESAN TESTIMONI</div>
                        <div class="data-desc">"{{ $testimonial->message }}"</div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="inline-actions">
                    <a href="{{ route('testimonial.edit', $testimonial->id) }}" class="btn-act bg-edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Testimoni
                    </a>
                    <form action="{{ route('testimonial.destroy', $testimonial->id) }}" method="POST" style="margin: 0; display:flex;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-act bg-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus Testimoni ini?')">
                            <i class="fa-solid fa-trash-can"></i> Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
