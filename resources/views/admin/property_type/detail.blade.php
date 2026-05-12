@extends('admin.layouts.app')

@section('content')
<style>
    .page-container { padding: 30px; background-color: #ffffff; min-height: 100vh; }
    .detail-card { background: #ebebeb; border-radius: 12px; padding: 40px; max-width: 900px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }

    .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
    .data-item { margin-bottom: 20px; }
    .data-label { font-size: 12px; font-weight: 700; color: #777; margin-bottom: 5px; text-transform: uppercase; }
    .data-value { font-size: 16px; font-weight: 800; color: #222; }

    .dp-list { background: #fff; padding: 15px; border-radius: 8px; border: 1px solid #ccc; }
    .dp-item { display: flex; justify-content: space-between; font-size: 14px; font-weight: 700; margin-bottom: 5px; border-bottom: 1px dashed #eee; padding-bottom: 5px; }

    .img-manage-box { background: #d6d6d6; padding: 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }

    .btn-action { padding: 10px 20px; border-radius: 6px; font-weight: 700; color: #fff; text-decoration: none; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-size: 13px; }

    @media (max-width: 600px) {
        .data-grid { grid-template-columns: 1fr; gap: 10px; }
        .img-manage-box { flex-direction: column; text-align: center; gap: 15px; }
        .action-footer { flex-direction: column; }
        .btn-action { width: 100%; justify-content: center; margin-bottom: 10px; }
    }
</style>

<div class="page-container">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 30px; text-align: center;">Detail Type Rumah</h1>

    <div class="detail-card">
        <div class="data-grid">
            <div>
                <div class="data-item">
                    <div class="data-label">Nama Type Rumah</div>
                    <div class="data-value">Type {{ $type->name_type }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Nama Property</div>
                    <div class="data-value">{{ $type->property->name_property ?? '-' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Harga Jual</div>
                    <div class="data-value" style="color: #31743a;">Rp {{ number_format($type->harga_jual, 0, ',', '.') }}</div>
                </div>
            </div>

            <div>
                <div class="data-item">
                    <div class="data-label">Jenis Type Rumah</div>
                    <div class="data-value">{{ $type->jenis_type }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Jumlah Kamar</div>
                    <div class="data-value">{{ $type->jml_kamar }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Harga KPR</div>
                    <div class="data-value">Rp {{ number_format($type->kpr, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="data-item">
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
                    <span style="color: #888;">Tidak ada data DP</span>
                @endif
            </div>
        </div>

        <div class="data-grid" style="margin-top: 20px; margin-bottom: 0;">
            <div class="data-item">
                <div class="data-label">Booking Fee</div>
                <div class="data-value">Rp {{ number_format($type->booking, 0, ',', '.') }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Unggulan</div>
                <div class="data-value">{{ $type->is_featured ? 'Ya' : 'Tidak' }}</div>
            </div>
        </div>

        <div class="data-item" style="margin-top: 20px; border-top: 2px solid #ccc; padding-top: 20px;">
            <div class="data-label">Gambar Type Rumah</div>
            <div class="img-manage-box">
                <div style="display: flex; align-items: center; gap: 15px;">
                    @if($type->images->count() > 0)
                        <div style="background: #fff; padding: 5px; border-radius: 6px; font-weight: bold;">{{ $type->images->count() }} Gambar Terupload</div>
                    @else
                        <i class="fa-regular fa-image fa-3x" style="color: #aaa;"></i>
                        <span style="font-size: 14px; color: #777;">Belum ada gambar</span>
                    @endif
                </div>

                <a href="{{ url('admin/property_type_image?type_id=' . $type->id) }}" class="btn-action" style="background: #31743a;">
                    <i class="fa-solid fa-gear"></i> Kelola Gambar
                </a>
            </div>
        </div>

        <div class="action-footer" style="display: flex; justify-content: space-between; margin-top: 40px;">
            <a href="{{ route('property_type.index') }}" class="btn-action" style="background: #007bff;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>

            <div style="display: flex; gap: 10px;">
                <a href="{{ route('property_type.edit', $type->id) }}" class="btn-action" style="background: #f39c12;"><i class="fa-solid fa-pen"></i> Edit</a>
                <form action="{{ route('property_type.destroy', $type->id) }}" method="POST" style="margin: 0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action" style="background: #e74c3c;" onclick="return confirm('Hapus Type Rumah ini?')"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
