@extends('admin.layouts.app')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }

    /* Header (100% Identik dengan Halaman Property) */
    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin: 0; }

    /* Alert Sukses */
    .alert-success { background: #d1e7dd; color: #0f5132; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; font-weight: 600; border: 1px solid #badbcc; }

    /* Form Card (Bagian Form yang sudah oke) */
    .form-card { background: #ebebeb; border-radius: 12px; padding: 35px; width: 100%; margin-bottom: 30px; }

    .section-title { font-size: 18px; font-weight: 800; color: #222; margin-bottom: 25px; margin-top: 0; }

    /* Form Elements - Horizontal Layout */
    .form-group-horizontal { display: flex; align-items: center; margin-bottom: 20px; gap: 20px; }
    .form-label { width: 200px; font-size: 12px; font-weight: 800; color: #555; text-transform: uppercase; margin: 0; flex-shrink: 0; }
    .form-control { flex-grow: 1; padding: 14px 15px; border-radius: 8px; border: 1px solid #ccc; font-size: 14px; background: #fff; outline: none; transition: 0.2s; font-family: inherit; color: #333; }
    .form-control:focus { border-color: #31743a; }

    /* Area Submit */
    .submit-wrapper { display: flex; justify-content: flex-end; margin-top: 30px; padding-top: 25px; border-top: 1px solid #dcdcdc; }
    .btn-submit { background-color: #0d6efd; color: #fff; padding: 14px 28px; border-radius: 8px; border: none; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; font-family: inherit;}
    .btn-submit:hover { background-color: #0b5ed7; }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .page-container { padding: 15px; }
        .form-card { padding: 25px; }

        .header-flex { flex-direction: column; align-items: stretch; text-align: center; gap: 15px; }
        .page-title { text-align: center; width: 100%; }

        .form-group-horizontal { flex-direction: column; align-items: stretch; gap: 8px; }
        .form-label { width: 100%; }

        .submit-wrapper { justify-content: center; }
        .btn-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">
    <!-- Menggunakan pembungkus header-flex agar margin konsisten dengan halaman lain -->
    <div class="header-flex">
        <h1 class="page-title">Settings</h1>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="form-card">
        <h2 class="section-title">Informasi Kontak</h2>

        <form action="{{ route('setting.store') }}" method="POST">
            @csrf

            <div class="form-group-horizontal">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="Contoh: 081234567890">
            </div>

            <div class="form-group-horizontal">
                <label class="form-label">Nomor WhatsApp</label>
                <input type="text" name="contact_whatsapp" class="form-control" value="{{ $settings['contact_whatsapp'] ?? '' }}" placeholder="Contoh: 6281234567890">
            </div>

            <div class="form-group-horizontal">
                <label class="form-label">Email</label>
                <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}" placeholder="Contoh: info@property.com">
            </div>

            <div class="form-group-horizontal">
                <label class="form-label">Alamat Lengkap</label>
                <input type="text" name="contact_address" class="form-control" value="{{ $settings['contact_address'] ?? '' }}" placeholder="Masukkan alamat lengkap kantor...">
            </div>

            <div class="submit-wrapper">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
