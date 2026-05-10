<style>
    .topbar {
        height: 60px;
        background-color: var(--topbar-bg);
        display: flex;
        align-items: center;
        padding: 0 20px;
    }

    .topbar-toggle {
        display: none; /* Sembunyikan di Desktop */
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #333;
    }
</style>

<div class="topbar">
    <button class="topbar-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>
    </div>
