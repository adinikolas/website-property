@extends('admin.layouts.app')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    .header-flex {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 30px; flex-wrap: wrap; gap: 15px;
    }

    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    /* Form Card Styles - Lebar menyesuaikan jendela (100%) */
    .form-card {
        background-color: #ebebeb;
        border-radius: 12px;
        padding: 30px;
        width: 100%;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .form-group { margin-bottom: 20px; }

    label {
        display: block; font-size: 14px; font-weight: 700;
        color: #444; margin-bottom: 8px; text-transform: uppercase;
    }

    input[type="text"], textarea, input[type="file"] {
        width: 100%; padding: 12px 15px; border-radius: 8px;
        border: 1px solid #ccc; background-color: #fff;
        font-size: 14px; transition: 0.2s;
    }

    input:focus, textarea:focus { outline: none; border-color: #31743a; box-shadow: 0 0 0 3px rgba(49, 116, 58, 0.1); }

    /* Area Upload Gambar */
    .upload-preview {
        width: 100%; height: 250px; background-color: #d6d6d6;
        border-radius: 8px; display: flex; align-items: center;
        justify-content: center; margin-bottom: 10px; overflow: hidden;
        border: 2px dashed #bbb;
    }

    .upload-preview img { width: 100%; height: 100%; object-fit: cover; }

    .btn-submit {
        background-color: #31743a; color: #fff; width: 100%;
        padding: 14px; border-radius: 8px; border: none;
        font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.2s;
    }
    .btn-submit:hover { background-color: #24582a; transform: translateY(-2px); }

    .btn-back {
        padding: 10px 18px; border-radius: 8px; font-weight: 700;
        text-decoration: none; color: #fff; background-color: #6c757d;
        font-size: 13px; display: inline-flex; align-items: center; gap: 8px;
    }

    /* === RESPONSIVE === */
    @media (max-width: 600px) {
        .page-container { padding: 15px; }
        .header-flex { flex-direction: column; text-align: center; }
        .form-card { padding: 20px; }
        .upload-preview { height: 180px; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Edit Property</h1>
        <a href="{{ route('property.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Batal
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('property.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Perumahan / Property</label>
                <input type="text" name="name_property" value="{{ $property->name_property }}" required>
            </div>

            <div class="form-group">
                <label>Deskripsi Lengkap</label>
                <textarea name="description" rows="5" required>{{ $property->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Ubah / Tambah Gambar <span style="font-weight: 400; text-transform: none; color: #888;">(Biarkan kosong jika tidak ingin mengubah gambar)</span></label>
                <div class="upload-preview" id="preview-container">
                    @if($property->image)
                        <img id="image-preview" src="{{ asset('storage/' . $property->image) }}" style="display: block;">
                        <div id="placeholder-text" style="display: none; text-align: center; color: #888;">
                            <i class="fa-regular fa-image fa-3x"></i>
                            <p style="font-size: 12px; margin-top: 10px;">Preview Gambar</p>
                        </div>
                    @else
                        <img id="image-preview" src="" style="display: none;">
                        <div id="placeholder-text" style="text-align: center; color: #888;">
                            <i class="fa-regular fa-image fa-3x"></i>
                            <p style="font-size: 12px; margin-top: 10px;">Belum ada gambar</p>
                        </div>
                    @endif
                </div>
                <input type="file" name="image" id="image-input" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-refresh" style="margin-right: 5px;"></i> Perbarui Data Property
            </button>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const placeholderText = document.getElementById('placeholder-text');

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
</script>
@endsection
