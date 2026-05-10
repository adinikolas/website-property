<style>
    .topbar {
        height: 60px;
        background-color: var(--topbar-bg);
        display: flex;
        align-items: center;
        padding: 0 20px;
        /* Desktop: posisi normal */
        position: static;
    }

    .topbar-toggle {
        display: none; /* Sembunyikan di Desktop */
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #333;
    }

    /* === KHUSUS TAMPILAN MOBILE === */
    @media (max-width: 768px) {
        .topbar {
            /* Membuat Navbar tetap di atas saat di-scroll */
            position: sticky;
            top: 0;
            z-index: 90; /* Memastikan Navbar berada di atas konten lain */
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); /* Memberi bayangan tipis ke bawah */
        }

        .topbar-toggle {
            display: block; /* Munculkan tombol hamburger menu */
        }
    }
</style>

<div class="topbar">
    <button class="topbar-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>
    </div>
