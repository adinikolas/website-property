@extends('admin.layouts.app')

@section('title', 'Edit Type Rumah')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }
    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }
    .btn-back { padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; background-color: #6c757d; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-back:hover { background-color: #5a6268; }

    .form-card { background: #ebebeb; border-radius: 12px; padding: 35px; width: 100%; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 20px; }
    .form-full { grid-column: 1 / -1; margin-bottom: 20px; }

    label { display: block; font-size: 12px; font-weight: 800; color: #555; margin-bottom: 8px; text-transform: uppercase; }
    input, select { width: 100%; padding: 14px 15px; border-radius: 8px; border: 1px solid #ccc; font-size: 14px; background: #fff; outline: none; transition: 0.2s; }
    input:focus, select:focus { border-color: #31743a; }

    .dp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 15px; }
    .dp-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px; }
    .btn-dp { padding: 10px 18px; border-radius: 6px; border: none; color: #fff; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; }
    .btn-dp:hover { opacity: 0.8; }

    /* Section Gambar (Rasio 280x180) */
    .gambar-section { display: flex; gap: 25px; align-items: flex-start; margin-top: 10px; }
    .gambar-box { width: 280px; height: 180px; background: #d6d6d6; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #888; flex-shrink: 0; overflow: hidden; border: 2px dashed #bbb;}
    .gambar-box img { width: 100%; height: 100%; object-fit: cover; }

    /* Area Penjelasan & Tombol Kelola Gambar - flex-grow: 1 agar area mentok ke kanan */
    .gambar-info-area { flex-grow: 1; display: flex; flex-direction: column; align-items: flex-start; }

    .btn-manage-img { background: #31743a; color: #fff; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; height: fit-content; transition: 0.2s; }
    .btn-manage-img:hover { background: #24582a; }

    /* Garis Pemisah */
    .form-divider { border: 0; height: 1px; background: #dcdcdc; margin: 30px 0 20px 0; }

    /* Tombol Simpan Rata Kanan (Warna Biru) */
    .submit-wrapper { display: flex; justify-content: flex-end; margin-top: 10px; }
    .btn-submit { background-color: #0d6efd; color: #fff; padding: 14px 28px; border-radius: 8px; border: none; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px;}
    .btn-submit:hover { background-color: #0b5ed7; }

    /* Responsif Mobile Khusus */
    @media (max-width: 600px) {
        .page-container { padding: 15px; }
        .form-card { padding: 20px; }
        .form-grid { grid-template-columns: 1fr; gap: 15px; }
        .dp-row { grid-template-columns: 1fr; gap: 15px; }
        .gambar-section { flex-direction: column; }
        .gambar-box { width: 100%; height: 200px; }

        .header-flex { flex-direction: column; align-items: stretch; text-align: center; }
        .btn-back { width: 100%; justify-content: center; }
        .dp-actions { flex-direction: column; }
        .btn-dp { width: 100%; justify-content: center; }

        .gambar-info-area { align-items: stretch; text-align: center; }
        .btn-manage-img { width: 100%; justify-content: center; }

        .submit-wrapper { justify-content: center; }
        .btn-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Edit Type Rumah</h1>
        <a href="{{ route('property_type.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Batal</a>
    </div>

    <div class="form-card">
        <form action="{{ route('property_type.update', $type->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div>
                    <label>Nama Type Rumah</label>
                    <input type="text" name="name_type" value="{{ $type->name_type }}" required>
                </div>
                <div>
                    <label>Jenis Type Rumah</label>
                    <select name="jenis_type" required>
                        <option value="Subsidi" {{ $type->jenis_type == 'Subsidi' ? 'selected' : '' }}>Subsidi</option>
                        <option value="Komersil" {{ $type->jenis_type == 'Komersil' ? 'selected' : '' }}>Komersil</option>
                    </select>
                </div>
                <div>
                    <label>Nama Property</label>
                    <select name="property_id" required>
                        @foreach($properties as $prop)
                            <option value="{{ $prop->id }}" {{ $type->property_id == $prop->id ? 'selected' : '' }}>{{ $prop->name_property }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Jumlah Kamar</label>
                    <input type="number" name="jml_kamar" value="{{ $type->jml_kamar }}" required>
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label>Harga Jual</label>
                    <input type="number" name="harga_jual" value="{{ $type->harga_jual }}" required>
                </div>
                <div>
                    <label>Harga KPR</label>
                    <input type="number" name="kpr" value="{{ $type->kpr }}" required>
                </div>
            </div>

            <!-- Bagian DP -->
            <div class="form-full" style="margin-top: 10px;">
                <label>Daftar DP (Uang Muka)</label>
                <div id="dp-container">
                    @foreach($type->dp ?? [['nama'=>'', 'harga'=>'']] as $dp)
                        <div class="dp-row">
                            <input type="text" name="dp_nama[]" value="{{ $dp['nama'] ?? '' }}" placeholder="Jenis DP" required>
                            <input type="number" name="dp_harga[]" value="{{ $dp['harga'] ?? '' }}" placeholder="Nominal" required>
                        </div>
                    @endforeach
                </div>
                <div class="dp-actions">
                    <button type="button" class="btn-dp" style="background: #31743a;" onclick="addDpRow()">
                        <i class="fa-solid fa-plus"></i> Tambah Jenis DP
                    </button>
                    <button type="button" class="btn-dp" style="background: #e74c3c;" onclick="removeDpRow()">
                        <i class="fa-solid fa-trash"></i> Hapus Jenis DP
                    </button>
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label>Booking Fee</label>
                    <input type="number" name="booking" value="{{ $type->booking }}" required>
                </div>
                <div>
                    <label>Jadikan Unggulan?</label>
                    <select name="is_featured" required>
                        <option value="0" {{ $type->is_featured == 0 ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ $type->is_featured == 1 ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>
            </div>

            <!-- Bagian Kelola Gambar -->
            <div class="form-full">
                <label>Gambar Type Rumah</label>
                <div class="gambar-section">
                    <div class="gambar-box">
                        @if($type->primaryImage)
                            <img src="{{ asset('storage/' . $type->primaryImage->image_path) }}">
                        @else
                            <i class="fa-regular fa-image fa-3x" style="margin-bottom: 10px; opacity: 0.2;"></i>
                            <span style="font-size: 11px;">(Belum ada gambar)</span>
                        @endif
                    </div>

                    <div class="gambar-info-area">
                        <a href="{{ url('admin/property_type_image?type_id=' . $type->id) }}" class="btn-manage-img">
                            <i class="fa-solid fa-gear"></i> Kelola Gambar
                        </a>
                        <p style="font-size: 12px; color: #777; margin-top: 10px; line-height: 1.5;">
                            *Anda akan diarahkan ke menu Galeri Gambar untuk menambah, menghapus, atau mengurutkan gambar pada Type Rumah ini.
                        </p>
                    </div>
                </div>
            </div>

            <hr class="form-divider">

            <div class="submit-wrapper">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan Type Rumah
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addDpRow() {
        const container = document.getElementById('dp-container');
        const row = document.createElement('div');
        row.className = 'dp-row';
        row.innerHTML = `<input type="text" name="dp_nama[]" placeholder="Jenis DP" required><input type="number" name="dp_harga[]" placeholder="Nominal" required>`;
        container.appendChild(row);
    }
    function removeDpRow() {
        const container = document.getElementById('dp-container');
        if (container.children.length > 1) {
            container.removeChild(container.lastChild);
        } else {
            alert('Minimal harus ada 1 jenis DP!');
        }
    }
</script>
@endsection
