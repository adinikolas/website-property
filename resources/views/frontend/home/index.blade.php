@extends('frontend.layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Plus Jakarta Sans', sans-serif; /* <--- UBAH DI SINI */
        overflow-x: hidden;
        background-color: #f9fafb;
    }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

    /* Global Section Spacing */
    section { padding: 80px 0; }
    .hero-section { padding: 120px 0 90px 0; }

    /* Membungkus Judul agar Margin bisa dikontrol presisi */
    .section-header {
        text-align: center;
        margin-bottom: 55px;
    }
    .section-title {
        font-size: 32px;
        font-weight: 900;
        margin: 0;
        text-transform: uppercase;
        color: #111827;
        letter-spacing: 0.5px;
    }
    .section-subtitle {
        font-size: 16px;
        color: #6b7280;
        margin: 12px 0 0 0;
    }

    /* Utilitas Warna Teks Terang untuk Section Gelap */
    .text-light .section-title { color: #f9fafb; }
    .text-light .section-subtitle { color: rgba(255, 255, 255, 0.85); }

    /* Animasi CSS (Scroll Reveal) */
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.5, 0, 0, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }

    /* Efek Hover Global untuk semua Card */
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* 1. Hero Section (Admin Green Gradient) */
    .hero-section { background: linear-gradient(135deg, #3a8b45 0%, #24582a 100%); color: #fff; }
    .hero-title { font-size: 52px; font-weight: 900; margin: 0 0 20px 0; line-height: 1.15; text-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .hero-desc { font-size: 18px; margin-bottom: 40px; max-width: 600px; line-height: 1.6; color: #e8f2e9; }
    .hero-buttons { display: flex; gap: 15px; }
    .btn-primary { background: #111827; color: #fff; padding: 14px 30px; border-radius: 8px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .btn-primary:hover { background: #1f2937; transform: translateY(-3px); }
    .btn-outline { background: transparent; color: #fff; padding: 14px 30px; border-radius: 8px; text-decoration: none; font-weight: 700; border: 2px solid #fff; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; }
    .btn-outline:hover { background: #fff; color: #24582a; transform: translateY(-3px); }

    /* 2. Promo Section */
    .promo-section { background: #ffffff; }
    .promo-grid {
        display: flex;
        justify-content: center; /* Kunci agar otomatis ke tengah */
        flex-wrap: wrap;
        gap: 25px;
    }
    .promo-box {
        /* Kalkulasi: 100% lebar dibagi 3 kolom, dikurangi jarak gap 25px */
        flex: 0 0 calc((100% - 50px) / 3);
        box-sizing: border-box;
        background: #f3f4f6;
        padding: 30px;
        text-align: center;
        border-radius: 12px;
        font-weight: 800;
        font-size: 18px;
        color: #111827;
        border: 1px solid #e5e7eb;
    }

    /* 3. Tentang Section (Dark Slate) */
    .about-section { background: #111827; color: #fff; text-align: center; }
    .about-text { font-size: 17px; line-height: 1.8; color: #9ca3af; max-width: 800px; margin: 0 auto; }

    /* 4. Keunggulan Section */
    .keunggulan-section { background: #f9fafb; }
    .keunggulan-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
    .keunggulan-card { background: #ffffff; padding: 40px 30px; text-align: center; border-radius: 16px; border: 1px solid #f3f4f6; }
    .keunggulan-card h3 { font-size: 20px; font-weight: 800; color: #111827; margin: 0 0 15px 0; }
    .keunggulan-card p { font-size: 15px; color: #6b7280; line-height: 1.6; margin: 0; }

    /* 5. Perumahan Unggulan (Dark Slate dengan Elemen Putih) */
    .perumahan-section { background: #111827; color: #fff; }
    .perumahan-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Mengatur item ganjil ke tengah */
        gap: 40px;
    }
    .property-card {
        /* Kalkulasi: 100% dibagi 2 kolom, dikurangi jarak gap 40px */
        flex: 0 0 calc((100% - 40px) / 2);
        box-sizing: border-box;
        background: #1f2937;
        padding: 25px;
        border-radius: 16px;
        color: #fff;
        border: 1px solid #374151;
    }
    .property-img { width: 100%; height: 260px; background: #374151; border-radius: 10px; margin-bottom: 25px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .property-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .property-card:hover .property-img img { transform: scale(1.08); }
    .property-title { font-size: 24px; font-weight: 800; margin: 0 0 10px 0; color: #f9fafb; }
    .property-desc { font-size: 15px; color: #9ca3af; line-height: 1.6; margin: 0 0 25px 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    /* Tombol menggunakan Admin Green (#31743a) */
    .btn-dark { background: #31743a; color: #fff; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px; display: inline-block; transition: 0.3s; }
    .btn-dark:hover { background: #24582a; }

    /* 6. Keuntungan Section */
    .keuntungan-section { background: linear-gradient(135deg, #3a8b45 0%, #24582a 100%); color: #fff; }
    .keuntungan-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; }
    .keuntungan-card { background: #ffffff; padding: 30px; border-radius: 16px; text-align: center; color: #111827; }
    /* Ikon dan lingkaran memakai warna Admin Green yang disesuaikan */
    .icon-circle { width: 65px; height: 65px; background: #e8f2e9; color: #31743a; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(49, 116, 58, 0.2); }
    .keuntungan-card p { margin: 0; font-size: 16px; font-weight: 600; line-height: 1.5; color: #374151; }

    /* 7. Galeri Section */
    .galeri-section { background: #111827; color: #fff; }
    .galeri-slider { width: 100%; aspect-ratio: 16 / 9; max-height: 550px; border-radius: 16px; overflow: hidden; background: #1f2937; box-shadow: 0 10px 20px rgba(0,0,0,0.3); border: 1px solid #374151; }
    .galeri-slider .swiper-slide { display: flex; align-items: center; justify-content: center; }
    .galeri-slider .swiper-slide img { width: 100%; height: 100%; object-fit: cover; }
    .swiper-pagination-bullet-active { background-color: #31743a !important; }
    .swiper-button-next, .swiper-button-prev { color: #31743a !important; background: rgba(255,255,255,0.8); padding: 30px 20px; border-radius: 8px; }
    .swiper-button-next::after, .swiper-button-prev::after { font-size: 20px !important; font-weight: bold; }

    /* 8. Testimoni Section */
    .testimoni-section { background: #f9fafb; }
    .testimoni-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Mengatur item ganjil ke tengah */
        gap: 35px;
    }
    .testi-card {
        /* Kalkulasi: 100% dibagi 2 kolom, dikurangi jarak gap 35px */
        flex: 0 0 calc((100% - 35px) / 2);
        box-sizing: border-box;
        background: #ffffff;
        padding: 35px;
        border-radius: 16px;
        border: 1px solid #f3f4f6;
    }
    .testi-quote { font-size: 15px; font-style: italic; color: #4b5563; line-height: 1.7; margin: 0 0 25px 0; }
    .testi-user { display: flex; align-items: center; gap: 15px; }
    .testi-user img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }
    .testi-user-info h4 { margin: 0; font-size: 17px; font-weight: 800; color: #111827; }
    .testi-user-info span { font-size: 13px; color: #6b7280; font-weight: 600; }

    /* 9. CTA Footer */
    .cta-footer { background: linear-gradient(135deg, #3a8b45 0%, #24582a 100%); color: #fff; padding: 80px 0; text-align: center; }
    .cta-footer h2 { font-size: 28px; font-weight: 900; margin: 0 0 15px 0; }
    .cta-footer p { font-size: 17px; margin: 0 0 35px 0; color: #e8f2e9; }
    .btn-wa { background: #ffffff; color: #24582a; padding: 16px 35px; border-radius: 10px; text-decoration: none; font-weight: 900; font-size: 18px; display: inline-flex; align-items: center; gap: 10px; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .btn-wa:hover { transform: scale(1.05); background: #f9fafb; }
    .copyright { background: #030712; color: #6b7280; text-align: center; padding: 25px 0; font-size: 13px; font-weight: 500; }

    /* Mobile Responsive */
    @media(max-width: 768px) {
        section { padding: 60px 0; }
        .hero-section { padding: 100px 0 80px 0; }
        .keunggulan-grid, .keuntungan-grid { grid-template-columns: 1fr; }
        .promo-box, .property-card, .testi-card { flex: 0 0 100%; }
        .hero-title { font-size: 40px; }
        .hero-buttons { flex-direction: column; }
        .section-title { font-size: 26px; }
        .section-header { margin-bottom: 40px; }
        .swiper-button-next, .swiper-button-prev { display: none; }
    }
</style>

<!-- Load CSS Swiper.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@php
    $raw_wa = $settings['contact_whatsapp'] ?? '6281234567890';
    $wa_number = preg_replace('/[^0-9]/', '', $raw_wa);
    if(str_starts_with($wa_number, '0')) {
        $wa_number = '62' . substr($wa_number, 1);
    }
    $wa_link = "https://wa.me/{$wa_number}?text=Halo%20CKM%20City%20Karawang,%20saya%20ingin%20info%20lebih%20lanjut.";
@endphp

<!-- 1. Hero Section -->
<section class="hero-section">
    <div class="container reveal">
        <h1 class="hero-title">CKM City<br>Karawang</h1>
        <p class="hero-desc">Langkah awal untuk masa depan cemerlang, hunian nyaman & strategis di pusat kota Karawang. Wujudkan rumah impian Anda sekarang.</p>
        <div class="hero-buttons">
            <a href="{{ $wa_link }}" class="btn-primary" target="_blank"><i class="fa-brands fa-whatsapp"></i> Hubungi Marketing</a>
            <a href="#perumahan" class="btn-outline"><i class="fa-solid fa-house"></i> Lihat Perumahan</a>
        </div>
    </div>
</section>

<!-- 2. Promo Section -->
<section class="promo-section">
    <div class="container">
        <div class="section-header reveal">
            <h2 class="section-title">Promo Utama</h2>
        </div>
        <div class="promo-grid">
            <div class="promo-box hover-card reveal">DP mulai 0%</div>
            <div class="promo-box hover-card reveal" style="transition-delay: 0.1s;">Booking mulai 500rb</div>
            {{-- <div class="promo-box hover-card reveal" style="transition-delay: 0.2s;">Free AC & Mesin Cuci</div> --}}
        </div>
    </div>
</section>

<!-- 3. Tentang Section -->
<section class="about-section text-light">
    <div class="container reveal">
        <div class="section-header">
            <h2 class="section-title">Tentang CKM City Karawang</h2>
        </div>
        <p class="about-text">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat.
        </p>
    </div>
</section>

<!-- 4. Keunggulan Section -->
<section class="keunggulan-section">
    <div class="container">
        <div class="section-header reveal">
            <h2 class="section-title">Keunggulan</h2>
            <p class="section-subtitle">Banyak Keunggulan Perumahan Citra Karawang Megah (CKM)</p>
        </div>
        <div class="keunggulan-grid">
            <div class="keunggulan-card hover-card reveal">
                <h3>Harga Terjangkau &<br>Cicilan Ringan</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="keunggulan-card hover-card reveal" style="transition-delay: 0.1s;">
                <h3>Lokasi<br>Strategis</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="keunggulan-card hover-card reveal" style="transition-delay: 0.2s;">
                <h3>Proses KPR<br>Mudah & Cepat</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
        </div>
    </div>
</section>

<!-- 5. Perumahan Unggulan Section -->
<section id="perumahan" class="perumahan-section text-light">
    <div class="container">
        <div class="section-header reveal">
            <h2 class="section-title">Perumahan Unggulan</h2>
        </div>
        <div class="perumahan-grid">
            @foreach($properties as $index => $property)
                <div class="property-card hover-card reveal" style="transition-delay: {{ $index * 0.1 }}s;">
                    <div class="property-img">
                        @if($property->image)
                            <img src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->name_property }}">
                        @else
                            <i class="fa-regular fa-image fa-4x" style="color: #4b5563;"></i>
                        @endif
                    </div>
                    <h3 class="property-title">{{ $property->name_property }}</h3>
                    <p class="property-desc">{{ $property->description }}</p>

                    <!-- PERUBAHAN LINK DI SINI -->
                    <a href="{{ route('frontend.property.show', $property->id) }}" class="btn-dark">Lihat Detail</a>
                    <!-- ====================== -->

                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 6. Keuntungan Section -->
<section class="keuntungan-section text-light">
    <div class="container">
        <div class="section-header reveal">
            <h2 class="section-title">Keuntungan</h2>
            <p class="section-subtitle">Kenapa Anda Perlu Punya Rumah di Citra Karawang Megah?</p>
        </div>
        <div class="keuntungan-grid">
            <div class="keuntungan-card hover-card reveal">
                <div class="icon-circle"><i class="fa-solid fa-check"></i></div>
                <p>Lingkungan bebas banjir, aman untuk keluarga tercinta.</p>
            </div>
            <div class="keuntungan-card hover-card reveal" style="transition-delay: 0.1s;">
                <div class="icon-circle"><i class="fa-solid fa-check"></i></div>
                <p>Fasilitas lengkap di dalam perumahan (Masjid, Taman).</p>
            </div>
            <div class="keuntungan-card hover-card reveal" style="transition-delay: 0.2s;">
                <div class="icon-circle"><i class="fa-solid fa-check"></i></div>
                <p>Akses dekat dengan kawasan industri Karawang.</p>
            </div>
            <div class="keuntungan-card hover-card reveal" style="transition-delay: 0.3s;">
                <div class="icon-circle"><i class="fa-solid fa-check"></i></div>
                <p>Nilai investasi tinggi yang terus naik setiap tahunnya.</p>
            </div>
        </div>
    </div>
</section>

<!-- 7. Galeri Section -->
<section class="galeri-section text-light">
    <div class="container reveal">
        <div class="section-header">
            <h2 class="section-title">Galeri</h2>
        </div>

        <div class="swiper galeri-slider">
            <div class="swiper-wrapper">
                @forelse($galleries as $gallery)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Galeri CKM">
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #4b5563; flex-direction: column;">
                            <i class="fa-regular fa-images fa-4x" style="margin-bottom: 15px;"></i>
                            <span>Belum ada gambar galeri</span>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- 8. Testimoni Section -->
<section class="testimoni-section">
    <div class="container">
        <div class="section-header reveal">
            <h2 class="section-title">Testimoni</h2>
            <p class="section-subtitle">Apa kata mereka yang sudah memiliki rumah di CKM?</p>
        </div>
        <div class="testimoni-grid">
            @foreach($testimonials as $index => $testi)
                <div class="testi-card hover-card reveal" style="transition-delay: {{ $index * 0.1 }}s;">
                    <p class="testi-quote">"{{ $testi->message }}"</p>
                    <div class="testi-user">
                        @if($testi->photo)
                            <img src="{{ asset('storage/' . $testi->photo) }}" alt="{{ $testi->name }}">
                        @else
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-user" style="color: #9ca3af; font-size: 24px;"></i>
                            </div>
                        @endif
                        <div class="testi-user-info">
                            <h4>{{ $testi->name }}</h4>
                            <span>{{ $testi->profesi }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 9. CTA Footer -->
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

<!-- Load JS Swiper.js -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Script Animasi Scroll & Inisialisasi Swiper Slider -->
<script>
    var swiper = new Swiper(".galeri-slider", {
        loop: true,
        grabCursor: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    function reveal() {
        var reveals = document.querySelectorAll(".reveal");
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 100;

            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add("active");
            }
        }
    }
    window.addEventListener("scroll", reveal);
    document.addEventListener("DOMContentLoaded", reveal);
</script>
@endsection
