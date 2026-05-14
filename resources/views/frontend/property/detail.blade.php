@extends('frontend.layouts.app')

@section('title', $property->name_property ?? 'Detail Property')

@section('content')
<style>
    body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; background-color: #f9fafb; }
    .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }

    section { padding: 80px 0; }

    /* Animasi CSS */
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.5, 0, 0, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 15px 20px -5px rgba(0, 0, 0, 0.1); }

    /* 1. Hero Detail Section */
    .hero-detail { background: linear-gradient(135deg, #3a8b45 0%, #24582a 100%); color: #fff; padding: 100px 0 60px 0; }
    .hero-flex { display: flex; justify-content: space-between; align-items: flex-end; gap: 30px; flex-wrap: wrap; }
    .hero-left { max-width: 600px; }
    .hero-title { font-size: 46px; font-weight: 900; margin: 0 0 15px 0; line-height: 1.1; text-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .hero-desc { font-size: 16px; margin: 0; line-height: 1.6; color: #e8f2e9; }
    .hero-right { text-align: right; }
    .price-label { font-size: 14px; color: #e8f2e9; margin-bottom: 5px; display: block; }
    .price-main { font-size: 32px; font-weight: 900; margin: 0; text-shadow: 0 4px 6px rgba(0,0,0,0.1); }

    /* 2. Info Boxes (3 Kolom) */
    .info-section { padding: 40px 0 0 0; background: #fff; }
    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .info-box { background: #e5e7eb; padding: 25px 15px; text-align: center; border-radius: 10px; font-weight: 900; font-size: 18px; color: #111827; border: 1px solid #d1d5db; }

    /* 3. Galeri Section (Dark Slate) */
    .galeri-section { background: #1f2937; color: #fff; margin-top: 60px; padding: 70px 0; }
    .section-title { font-size: 32px; font-weight: 900; margin: 0 0 40px 0; text-transform: uppercase; text-align: center; letter-spacing: 1px; }
    .galeri-slider { width: 100%; aspect-ratio: 16 / 9; max-height: 500px; border-radius: 16px; overflow: hidden; background: #111827; box-shadow: 0 10px 25px rgba(0,0,0,0.4); border: 1px solid #374151; }
    .galeri-slider .swiper-slide img { width: 100%; height: 100%; object-fit: cover; }
    .swiper-pagination-bullet-active { background-color: #10b981 !important; }
    .swiper-button-next, .swiper-button-prev { color: #fff !important; background: rgba(0,0,0,0.5); padding: 30px 20px; border-radius: 8px; }

    /* 4. Price List Section */
    .price-section { padding: 80px 0; background: #fff; }
    .price-title { color: #111827; }
    .price-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; }
    .price-card { background: #e5e7eb; padding: 30px; border-radius: 12px; text-align: center; border: 1px solid #d1d5db; display: flex; flex-direction: column; justify-content: center; }
    .pc-label { font-size: 15px; color: #4b5563; font-weight: 700; margin-bottom: 10px; }
    .pc-value { font-size: 24px; font-weight: 900; color: #31743a; margin: 0; }

    /* DP Box Khusus */
    .dp-box { padding: 20px 30px; text-align: left; }
    .dp-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px dashed #9ca3af; }
    .dp-row:last-child { border-bottom: none; }
    .dp-row-label { font-size: 14px; font-weight: 700; color: #4b5563; }
    .dp-row-val { font-size: 16px; font-weight: 900; color: #31743a; }

    /* 5. CTA Footer */
    .cta-footer { background: linear-gradient(135deg, #3a8b45 0%, #24582a 100%); color: #fff; padding: 80px 0; text-align: center; }
    .cta-footer h2 { font-size: 28px; font-weight: 900; margin: 0 0 15px 0; }
    .cta-footer p { font-size: 17px; margin: 0 0 35px 0; color: #e8f2e9; }
    .btn-wa { background: #ffffff; color: #24582a; padding: 16px 35px; border-radius: 10px; text-decoration: none; font-weight: 900; font-size: 18px; display: inline-flex; align-items: center; gap: 10px; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .btn-wa:hover { transform: scale(1.05); background: #f9fafb; }
    .copyright { background: #030712; color: #6b7280; text-align: center; padding: 25px 0; font-size: 13px; font-weight: 500; }

    /* Responsive Mobile */
    @media(max-width: 768px) {
        .hero-flex { flex-direction: column; align-items: flex-start; gap: 20px; }
        .hero-right { text-align: left; }
        .info-grid { grid-template-columns: 1fr; }
        .price-grid { grid-template-columns: 1fr; }
        .hero-title { font-size: 36px; }
        .swiper-button-next, .swiper-button-prev { display: none; }
    }
</style>

<!-- Load CSS Swiper.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@php
    $raw_wa = $settings['contact_whatsapp'] ?? '6281234567890';
    $wa_number = preg_replace('/[^0-9]/', '', $raw_wa);
    if(str_starts_with($wa_number, '0')) $wa_number = '62' . substr($wa_number, 1);
    $pesan = "Halo, saya tertarik dengan " . ($property->name_property ?? 'Property') . " tipe " . ($type->name_type ?? '');
    $wa_link = "https://wa.me/{$wa_number}?text=" . urlencode($pesan);
@endphp

<!-- 1. Hero Section -->
<section class="hero-detail">
    <div class="container reveal">
        <div class="hero-flex">
            <div class="hero-left">
                <h1 class="hero-title">{{ $property->name_property }}</h1>
                <p class="hero-desc">{{ $property->description }}</p>
            </div>
            <div class="hero-right">
                <span class="price-label">Harga mulai dari</span>
                <h2 class="price-main">Rp {{ number_format($type->harga_jual ?? 0, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</section>

<!-- 2. Info Boxes (Type, Kategori, Kamar) -->
@if($type)
<section class="info-section">
    <div class="container reveal">
        <div class="info-grid">
            <div class="info-box hover-card">Type {{ $type->name_type }}</div>
            <div class="info-box hover-card" style="transition-delay: 0.1s;">Rumah {{ $type->jenis_type }}</div>
            <div class="info-box hover-card" style="transition-delay: 0.2s;">{{ $type->jml_kamar }} Kamar Tidur</div>
        </div>
    </div>
</section>

<!-- 3. Galeri Section -->
<section class="galeri-section">
    <div class="container reveal">
        <h2 class="section-title">Galeri</h2>

        <div class="swiper galeri-slider">
            <div class="swiper-wrapper">
                @if($type->images && count($type->images) > 0)
                    @foreach($type->images as $img)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Galeri Type {{ $type->name_type }}">
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide" style="background: #374151;">
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af; flex-direction: column;">
                            <i class="fa-regular fa-images fa-4x" style="margin-bottom: 15px;"></i>
                            <span>Belum ada gambar galeri</span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- 4. Price List Section -->
<section class="price-section">
    <div class="container reveal">
        <h2 class="section-title price-title">Price List</h2>

        <div class="price-grid">
            <div class="price-card hover-card">
                <div class="pc-label">Harga Jual</div>
                <div class="pc-value">Rp {{ number_format($type->harga_jual ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="price-card hover-card" style="transition-delay: 0.1s;">
                <div class="pc-label">Harga KPR</div>
                <div class="pc-value">Rp {{ number_format($type->kpr ?? 0, 0, ',', '.') }}</div>
            </div>

            <div class="price-card dp-box hover-card" style="transition-delay: 0.2s;">
                @if(!empty($type->dp) && is_array($type->dp))
                    @foreach($type->dp as $dp)
                        <div class="dp-row">
                            <span class="dp-row-label">{{ $dp['nama'] ?? 'DP' }}</span>
                            <span class="dp-row-val">Rp {{ number_format($dp['harga'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="pc-label" style="text-align: center;">DP</div>
                    <div class="pc-value" style="text-align: center;">-</div>
                @endif
            </div>

            <div class="price-card hover-card" style="transition-delay: 0.3s;">
                <div class="pc-label">Booking</div>
                <div class="pc-value">Rp {{ number_format($type->booking ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- 5. CTA Footer -->
<section class="cta-footer reveal">
    <div class="container">
        <h2>SEGERA HUBUNGI UNTUK DAPATKAN PROMO MENARIK UNTUK ANDA!</h2>
        <p>Tim marketing kami siap melayani dan menjawab semua pertanyaan Anda.</p>
        <a href="{{ $wa_link }}" class="btn-wa" target="_blank">
            <i class="fa-brands fa-whatsapp" style="font-size: 22px;"></i> Chat via WhatsApp
        </a>
    </div>
</section>

<div class="copyright">
    Copyright &copy; {{ date('Y') }} CKM City Karawang. All Rights Reserved.
</div>

<!-- Load JS Swiper & Animasi -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".galeri-slider", {
        loop: true,
        grabCursor: true,
        autoplay: { delay: 3500, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    });

    function reveal() {
        var reveals = document.querySelectorAll(".reveal");
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            if (elementTop < windowHeight - 100) reveals[i].classList.add("active");
        }
    }
    window.addEventListener("scroll", reveal);
    document.addEventListener("DOMContentLoaded", reveal);
</script>
@endsection
