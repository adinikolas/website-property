@extends('admin.layouts.app')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    /* Header & Tombol Kembali */
    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    .btn-back { padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; background-color: #6c757d; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-back:hover { background-color: #5a6268; }

    /* Card Form (Warna abu-abu #ebebeb) */
    .form-card { background: #ebebeb; border-radius: 12px; padding: 40px; width: 100%; margin-bottom: 30px; }

    /* Form Elements */
    .form-group { margin-bottom: 25px; }
    .form-label { display: block; font-size: 12px; font-weight: 800; color: #888; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { width: 100%; padding: 14px 15px; border-radius: 8px; border: 1px solid #ccc; font-size: 14px; background: #fff; outline: none; color: #333; }

    .btn-add-img { width: 100%; background: #31743a; color: #fff; padding: 14px; border-radius: 8px; border: none; font-weight: 700; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 25px; transition: 0.2s; }
    .btn-add-img:hover { background: #24582a; }

    /* Grid Gambar (Desktop 2 Kolom, Serupa dengan Edit/Detail) */
    .images-manage-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    /* Block Gambar (Vertikal Layout) */
    .image-block {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
        border: 1px solid #ddd;
    }

    /* Ukuran disamakan dengan Halaman Detail & Edit (16:9) */
    .preview-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        height: auto;
        background: #d6d6d6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #ccc;
    }
    .preview-box img { width: 100%; height: 100%; object-fit: contain; }

    .block-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        gap: 10px;
    }

    .btn-remove-img {
        width: 100%;
        background: #e74c3c; color: #fff; border: none;
        padding: 12px 15px; border-radius: 8px; font-size: 13px; font-weight: 700;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: 0.2s;
    }
    .btn-remove-img:hover { background: #c0392b; }

    /* Teks Caption Gambar */
    .img-caption-edit {
        font-size: 14px;
        font-weight: 800;
        margin-top: 5px;
        text-align: center;
    }

    /* Area Submit Bawah */
    .submit-wrapper { display: flex; justify-content: flex-end; margin-top: 40px; padding-top: 25px; border-top: 1px solid #ccc; }
    .btn-submit { background-color: #0d6efd; color: #fff; padding: 14px 28px; border-radius: 8px; border: none; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-submit:hover { background-color: #0b5ed7; }

    .alert-error { background: #f8d7da; color: #721c24; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; font-weight: 600; border: 1px solid #f5c6cb; }

    /* Mobile Responsive */
    @media(max-width: 768px) {
        .page-container { padding: 15px; }
        .form-card { padding: 25px; }

        .header-flex { flex-direction: column; align-items: stretch; text-align: center; gap: 15px; }
        .page-title { text-align: center; width: 100%; }
        .btn-back { width: 100%; justify-content: center; }

        /* Ubah jadi 1 kolom di Mobile */
        .images-manage-grid { grid-template-columns: 1fr; }

        .submit-wrapper { flex-direction: column; }
        .btn-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Tambah Gambar Property</h1>
        <a href="{{ route('property_type_image.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('property_type_image.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Pilih Type Rumah</label>
                <select name="property_type_id" class="form-control" required>
                    <option value="">-- Pilih Type Rumah --</option>
                    @foreach($propertyTypes as $pt)
                        <option value="{{ $pt->id }}" {{ $selectedType == $pt->id ? 'selected' : '' }}>
                            Type {{ $pt->name_type }} - {{ $pt->property->name_property ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Galeri Gambar Property</label>

                <button type="button" class="btn-add-img" onclick="addImageBlock()">
                    <i class="fa-solid fa-plus"></i> Tambah Gambar
                </button>

                <!-- Container untuk Block Gambar Dinamis (menggunakan layout grid 2 kolom) -->
                <div id="dynamic-images-container" class="images-manage-grid"></div>
            </div>

            <div class="submit-wrapper">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save"></i> Simpan Gambar Property
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addImageBlock() {
        const container = document.getElementById('dynamic-images-container');
        const id = Date.now();

        const block = document.createElement('div');
        block.className = 'image-block';
        block.innerHTML = `
            <input type="file" name="images[]" id="file-${id}" style="display: none;" accept="image/*" required>
            <div class="preview-box">
                <img id="preview-${id}" src="" style="display: none;">
                <div id="placeholder-${id}" style="color: #aaa; text-align: center;">
                    <i class="fa-regular fa-image fa-3x"></i><br><span style="font-size: 11px; margin-top: 5px; display: inline-block;">(Pilih Gambar)</span>
                </div>
            </div>
            <div class="block-info">
                <button type="button" class="btn-remove-img" onclick="this.closest('.image-block').remove()">
                    <i class="fa-solid fa-trash-can"></i> Hapus Gambar
                </button>
                <div class="img-caption-edit" style="color: #2e7d32;">Gambar Baru</div>
            </div>
        `;
        container.appendChild(block);

        const fileInput = block.querySelector(`#file-${id}`);
        const imgPreview = block.querySelector(`#preview-${id}`);
        const placeholder = block.querySelector(`#placeholder-${id}`);

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                block.remove(); // Hapus block jika dialog file ditutup tanpa memilih gambar
            }
        });

        fileInput.click();
    }
</script>
@endsection
