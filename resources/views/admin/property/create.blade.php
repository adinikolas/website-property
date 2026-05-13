@extends('admin.layouts.app')

@section('title', 'Tambah Property')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }
    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }
    .btn-back { padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; background-color: #6c757d; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-back:hover { background-color: #5a6268; }

    .form-card { background: #ebebeb; border-radius: 12px; padding: 35px; width: 100%; }
    .form-full { margin-bottom: 25px; }

    label.form-label { display: block; font-size: 12px; font-weight: 800; color: #555; margin-bottom: 8px; text-transform: uppercase; }

    input[type="text"], textarea {
        width: 100%; padding: 14px 15px; border-radius: 8px; border: 1px solid #ccc;
        font-size: 14px; background: #fff; outline: none; transition: 0.2s; font-family: inherit;
    }
    input:focus, textarea:focus { border-color: #31743a; }

    /* Diubah menjadi flex-start agar tombol sejajar dengan sisi atas gambar */
    .gambar-section { display: flex; gap: 25px; align-items: flex-start; margin-top: 10px; }

    .gambar-box {
        width: 280px; height: 180px; background: #e5e7eb; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; flex-direction: column;
        color: #888; flex-shrink: 0; overflow: hidden;
    }
    .gambar-box img { width: 100%; height: 100%; object-fit: cover; display: none; }

    .gambar-actions { display: flex; flex-direction: column; gap: 12px; }

    .btn-img {
        padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 700;
        color: #fff; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
        transition: 0.2s; width: fit-content; text-decoration: none; font-family: inherit;
    }
    .btn-add-img { background-color: #228b22; }
    .btn-add-img:hover { background-color: #1a6b1a; }
    .btn-remove-img { background-color: #e50000; }
    .btn-remove-img:hover { background-color: #b30000; }

    /* Tombol Simpan Rata Kanan (Warna Biru) */
    .submit-wrapper { display: flex; justify-content: flex-end; margin-top: 30px; }
    .btn-submit { background-color: #0d6efd; color: #fff; padding: 14px 28px; border-radius: 8px; border: none; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px;}
    .btn-submit:hover { background-color: #0b5ed7; }

    @media (max-width: 600px) {
        .page-container { padding: 15px; } .form-card { padding: 20px; }
        .gambar-section { flex-direction: column; align-items: flex-start; }
        .gambar-box { width: 100%; height: 200px; }
        .gambar-actions { width: 100%; }
        .btn-img { width: 100%; justify-content: center; }
        .header-flex { flex-direction: column; align-items: stretch; text-align: center; }
        .btn-back { width: 100%; justify-content: center; }
        .submit-wrapper { justify-content: center; }
        .btn-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Tambah Property</h1>
        <a href="{{ route('property.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Batal</a>
    </div>

    <div class="form-card">
        <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-full">
                <label class="form-label">Nama Perumahan / Property</label>
                <input type="text" name="name_property" placeholder="Contoh: Perum Teras Elok" required>
            </div>

            <div class="form-full">
                <label class="form-label">Deskripsi Lengkap</label>
                <textarea name="description" rows="5" placeholder="Tuliskan detail lokasi, keunggulan, dll..." required></textarea>
            </div>

            <div class="form-full">
                <label class="form-label">Gambar Property <span style="font-weight: 600; text-transform: none; color: #888; letter-spacing: normal;">(Opsional)</span></label>

                <div class="gambar-section">
                    <div class="gambar-box" id="preview-container">
                        <div id="placeholder-text" style="text-align: center;">
                            <i class="fa-regular fa-image fa-3x" style="opacity: 0.2;"></i>
                        </div>
                        <img id="image-preview" src="" alt="Preview">
                    </div>

                    <div class="gambar-actions">
                        <input type="file" name="image" id="image-input" accept="image/*" style="display: none;">

                        <label for="image-input" class="btn-img btn-add-img">
                            <i class="fa-solid fa-plus"></i> Tambah Gambar
                        </label>

                        <button type="button" class="btn-img btn-remove-img" id="btn-remove-img">
                            <i class="fa-regular fa-trash-can"></i> Hapus Gambar
                        </button>
                    </div>
                </div>
            </div>

            <div class="submit-wrapper">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save"></i> Simpan Data Property
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const placeholderText = document.getElementById('placeholder-text');
    const btnRemove = document.getElementById('btn-remove-img');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                placeholderText.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    btnRemove.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.src = '';
        imagePreview.style.display = 'none';
        placeholderText.style.display = 'block';
    });
</script>
@endsection
