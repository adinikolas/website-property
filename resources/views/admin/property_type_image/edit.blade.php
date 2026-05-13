@extends('admin.layouts.app')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    /* Header & Tombol Kembali (Disamakan dengan Edit Property) */
    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }
    .btn-back { padding: 12px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; background-color: #6c757d; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
    .btn-back:hover { background-color: #5a6268; }

    /* Card Form (Padding disamakan menjadi 35px) */
    .form-card { background: #ebebeb; border-radius: 12px; padding: 35px; width: 100%; margin-bottom: 30px; }

    /* Form Elements (Warna label #555 & form-control fokus hijau) */
    .form-group { margin-bottom: 25px; }
    label.form-label { display: block; font-size: 12px; font-weight: 800; color: #555; margin-bottom: 8px; text-transform: uppercase; }
    .form-control { width: 100%; padding: 14px 15px; border-radius: 8px; border: 1px solid #ccc; font-size: 14px; background: #fff; outline: none; transition: 0.2s; font-family: inherit; color: #333; }
    .form-control:focus { border-color: #31743a; }

    .btn-add-img { width: 100%; background: #31743a; color: #fff; padding: 14px; border-radius: 8px; border: none; font-weight: 700; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 25px; transition: 0.2s; font-family: inherit; }
    .btn-add-img:hover { background: #24582a; }

    /* Grid Gambar (Layout Sesuai Screenshot) */
    .images-manage-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }

    .image-block { background: #fff; border-radius: 10px; padding: 20px; display: flex; flex-direction: column; align-items: stretch; gap: 15px; border: 1px solid #ddd; }
    .preview-box { width: 100%; aspect-ratio: 16 / 9; height: auto; background: #d6d6d6; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #ccc; }
    .preview-box img { width: 100%; height: 100%; object-fit: contain; }

    .block-info { display: flex; flex-direction: column; align-items: center; width: 100%; gap: 10px; }

    .btn-remove-img { width: 100%; background: #e74c3c; color: #fff; border: none; padding: 12px 15px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: 0.2s; font-family: inherit; }
    .btn-remove-img:hover { background: #c0392b; }

    .img-caption-edit { font-size: 14px; font-weight: 800; color: #555; margin-top: 5px; text-align: center; }

    /* Area Submit Bawah (Margin & Border disesuaikan) */
    .submit-wrapper { display: flex; justify-content: flex-end; margin-top: 30px; padding-top: 25px; border-top: 1px solid #dcdcdc; }
    .btn-submit { background-color: #0d6efd; color: #fff; padding: 14px 28px; border-radius: 8px; border: none; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; font-family: inherit; }
    .btn-submit:hover { background-color: #0b5ed7; }

    .alert-error { background: #f8d7da; color: #721c24; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; font-weight: 600; border: 1px solid #f5c6cb; }

    /* Mobile Responsive */
    @media(max-width: 768px) {
        .page-container { padding: 15px; }
        .form-card { padding: 20px; }
        .header-flex { flex-direction: column; align-items: stretch; text-align: center; gap: 15px; }
        .page-title { text-align: center; width: 100%; }
        .btn-back { width: 100%; justify-content: center; }
        .images-manage-grid { grid-template-columns: 1fr; }
        .submit-wrapper { justify-content: center; }
        .btn-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <h1 class="page-title">Edit Gambar Property</h1>
        <a href="{{ route('property_type_image.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Batal
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
        <form action="{{ route('property_type_image.update', $type->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Pilih Type Rumah</label>
                <select name="property_type_id" class="form-control" required>
                    @foreach($propertyTypes as $pt)
                        <option value="{{ $pt->id }}" {{ $type->id == $pt->id ? 'selected' : '' }}>
                            Type {{ $pt->name_type }} - {{ $pt->property->name_property ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Kelola Galeri Gambar</label>

                <button type="button" class="btn-add-img" onclick="addNewImageBlock()">
                    <i class="fa-solid fa-plus"></i> Tambah Gambar Baru
                </button>

                <!-- Hidden inputs untuk menampung ID gambar yang akan dihapus -->
                <div id="deleted-images-container"></div>

                <!-- Grid Gambar -->
                <div class="images-manage-grid">
                    <!-- Bagian Gambar Lama -->
                    @foreach($type->images as $index => $img)
                        <div class="image-block existing-block" id="existing-img-{{ $img->id }}">
                            <div class="preview-box">
                                <img src="{{ asset('storage/' . $img->image_path) }}">
                            </div>
                            <div class="block-info">
                                <button type="button" class="btn-remove-img" onclick="markAsDeleted({{ $img->id }})">
                                    <i class="fa-solid fa-trash-can"></i> Hapus Gambar
                                </button>
                                <div class="img-caption-edit">Gambar {{ $index + 1 }}</div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Bagian Container untuk Gambar Baru (Akan muncul di sini secara dinamis) -->
                    <div id="dynamic-images-container" style="display: contents;"></div>
                </div>
            </div>

            <div class="submit-wrapper">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan Gambar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function markAsDeleted(imageId) {
        const container = document.getElementById('deleted-images-container');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'deleted_images[]';
        input.value = imageId;
        container.appendChild(input);

        document.getElementById('existing-img-' + imageId).style.display = 'none';
    }

    function addNewImageBlock() {
        const container = document.getElementById('dynamic-images-container');
        const id = Date.now();

        const block = document.createElement('div');
        block.className = 'image-block';
        block.innerHTML = `
            <input type="file" name="new_images[]" id="file-${id}" style="display: none;" accept="image/*" required>
            <div class="preview-box">
                <img id="preview-${id}" src="" style="display: none;">
                <div id="placeholder-${id}" style="color: #aaa; text-align: center;">
                    <i class="fa-regular fa-image fa-3x"></i><br><span style="font-size: 11px; margin-top: 5px; display: inline-block;">(Pilih Gambar)</span>
                </div>
            </div>
            <div class="block-info">
                <button type="button" class="btn-remove-img" onclick="this.closest('.image-block').remove()">
                    <i class="fa-solid fa-xmark"></i> Batal
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
                block.remove();
            }
        });
        fileInput.click();
    }
</script>
@endsection
