@extends('admin.layouts.app')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    .btn-back { padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; background-color: #6c757d; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-back:hover { background-color: #5a6268; }

    .detail-card { background: #ebebeb; border-radius: 12px; padding: 40px; width: 100%; }

    /* Layout Grid Baris demi Baris */
    .data-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px 40px; /* Jarak vertikal 25px, Horizontal 40px */
        margin-bottom: 30px;
    }

    /* Untuk elemen yang membentang penuh (Daftar DP & Gambar) */
    .data-full {
        grid-column: 1 / -1;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    /* Styling Teks */
    .data-label { font-size: 12px; font-weight: 800; color: #888; margin-bottom: 6px; text-transform: uppercase; }
    .data-value { font-size: 18px; font-weight: 800; color: #222; }
    .data-value.green { color: #2e7d32; }

    /* Daftar DP (Sejajar dengan Grid Utama) */
    .dp-list { margin-top: 10px; width: 100%; }
    .dp-item {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Membagi DP jadi 2 kolom sejajar */
        gap: 25px 40px; /* Jarak disamakan dengan .data-grid */
        font-size: 18px;
        font-weight: 800;
        color: #222;
        padding: 12px 0;
        border-bottom: 1px dashed #ccc;
    }
    .dp-item:last-child { border-bottom: none; }

    /* Section Gambar */
    .gambar-section { display: flex; gap: 25px; align-items: flex-start; margin-top: 10px; }
    .gambar-box { width: 280px; height: 180px; background: #d6d6d6; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px dashed #bbb; flex-shrink: 0; }
    .gambar-box img { width: 100%; height: 100%; object-fit: cover; }

    .btn-kelola { background: #31743a; color: #fff; padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; height: fit-content; transition: 0.2s; }
    .btn-kelola:hover { background: #24582a; }

    /* Tombol Aksi Bawah */
    .bottom-actions { display: flex; justify-content: flex-end; gap: 15px; margin-top: 40px; border-top: 1px solid #ccc; padding-top: 25px; }
    .btn-act { padding: 12px 25px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; color: #fff; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }

    .bg-edit { background: #f39c12; color: #fff; }
    .bg-edit:hover { background: #d68910; }
    .bg-delete { background: #e74c3c; }
    .bg-delete:hover { background: #c0392b; }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        /* PENYESUAIAN PADDING AGAR TIDAK MENCIUT */
        .page-container { padding: 15px; }
        .detail-card { padding: 20px; }

        .data-grid { grid-template-columns: 1fr; gap: 20px; }
        .data-full { grid-column: 1; }

        /* Ubah DP jadi rata kiri-kanan di HP agar rapi */
        .dp-item { display: flex; justify-content: space-between; font-size: 15px; padding: 10px 0; }

        .header-flex { flex-direction: column; align-items: stretch; text-align: center; }
        .btn-back { width: 100%; justify-content: center; }
        .gambar-section { flex-direction: column; }
        .gambar-box { width: 100%; height: 220px; }
        .btn-kelola { width: 100%; justify-content: center; }
        .bottom-actions { flex-direction: column; }
        .btn-act { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Detail Type Rumah</h1>
        <a href="{{ route('property_type.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar</a>
    </div>

    <div class="detail-card">

        <div class="data-grid">
            <!-- Baris 1 -->
            <div>
                <div class="data-label">Nama Type Rumah</div>
                <div class="data-value">Type {{ $type->name_type }}</div>
            </div>
            <div>
                <div class="data-label">Jenis Type Rumah</div>
                <div class="data-value">{{ $type->jenis_type }}</div>
            </div>

            <!-- Baris 2 -->
            <div>
                <div class="data-label">Nama Property</div>
                <div class="data-value">{{ $type->property->name_property ?? '-' }}</div>
            </div>
            <div>
                <div class="data-label">Jumlah Kamar</div>
                <div class="data-value">{{ $type->jml_kamar }}</div>
            </div>

            <!-- Baris 3 -->
            <div>
                <div class="data-label">Harga Jual</div>
                <div class="data-value green">Rp {{ number_format($type->harga_jual, 0, ',', '.') }}</div>
            </div>
            <div>
                <div class="data-label">Harga KPR</div>
                <div class="data-value">Rp {{ number_format($type->kpr, 0, ',', '.') }}</div>
            </div>

            <!-- Baris 4: Daftar DP (Lebar Penuh) -->
            <div class="data-full">
                <div class="data-label">Daftar DP (Uang Muka)</div>
                <div class="dp-list">
                    @if(is_array($type->dp) && count($type->dp) > 0)
                        @foreach($type->dp as $dp)
                            <div class="dp-item">
                                <span>{{ $dp['nama'] }}</span>
                                <span>Rp {{ number_format((int)$dp['harga'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="dp-item" style="display: block; color: #888;">- Tidak ada data DP -</div>
                    @endif
                </div>
            </div>

            <!-- Baris 5 -->
            <div>
                <div class="data-label">Booking Fee</div>
                <div class="data-value">Rp {{ number_format($type->booking, 0, ',', '.') }}</div>
            </div>
            <div>
                <div class="data-label">Unggulan</div>
                <div class="data-value">{{ $type->is_featured ? 'Ya' : 'Tidak' }}</div>
            </div>

            <!-- Baris Gambar (Lebar Penuh) -->
            <div class="data-full" style="margin-top: 30px;">
                <div class="data-label">Galeri Gambar Type</div>
                <div class="gambar-section">
                    <div class="gambar-box">
                        @if($type->primaryImage)
                            <img src="{{ asset('storage/' . $type->primaryImage->image_path) }}" alt="Gambar Utama">
                        @else
                            <div style="text-align: center;">
                                <i class="fa-regular fa-image fa-3x" style="opacity: 0.2;"></i>
                                <div style="font-size: 11px; color: #888; margin-top: 5px;">(Belum ada gambar)</div>
                            </div>
                        @endif
                    </div>

                    <div style="flex-grow: 1;">
                        <a href="{{ url('admin/property_type_image?type_id=' . $type->id) }}" class="btn-kelola">
                            <i class="fa-solid fa-images"></i> Kelola Galeri Gambar
                        </a>
                        <p style="font-size: 12px; color: #777; margin-top: 10px; line-height: 1.5;">
                            *Klik tombol di atas untuk menambah atau mengatur urutan foto yang akan tampil pada detail perumahan di sisi pengunjung.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="bottom-actions">
            <a href="{{ route('property_type.edit', $type->id) }}" class="btn-act bg-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data
            </a>
            <form action="{{ route('property_type.destroy', $type->id) }}" method="POST" style="margin: 0; display:flex;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-act bg-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus Type Rumah ini?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Data
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
