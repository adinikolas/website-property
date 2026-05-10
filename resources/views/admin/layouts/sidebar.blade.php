<style>
    .sidebar {
        width: 250px;
        background-color: var(--sidebar-bg);
        color: var(--sidebar-text);
        display: flex;
        flex-direction: column;
        transition: 0.3s;
        position: relative;
        z-index: 100;
        height: 100vh;
        position: sticky;
        top: 0;
    }

    .sidebar-header {
        background: linear-gradient(135deg, #66cc66, #4ca64c);
        padding: 20px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
    }

    .sidebar-menu {
        flex: 1;
        padding: 20px 15px;
        list-style: none;
        overflow-y: auto;
    }

    .sidebar-menu li {
        margin-bottom: 5px;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #ddd;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.2s;
        font-size: 14px;
    }

    .sidebar-menu a i {
        width: 25px;
        font-size: 16px;
    }

    .sidebar-menu a:hover, .sidebar-menu a.active {
        background-color: var(--sidebar-hover);
        color: #fff;
    }

    .sidebar-footer {
        padding: 20px 15px;
    }

    .btn-logout {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #1a1a1a;
        color: #fff;
        text-align: center;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.2s;
        border: 1px solid #333;
    }

    .btn-logout:hover {
        background-color: #000;
    }

    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            height: 100%;
        }
    }
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        Admin Management
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ url('/admin/dashboard') }}" class="active">
                <i class="fa-solid fa-border-all"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/property') }}">
                <i class="fa-solid fa-house"></i> Property
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/property_type') }}">
                <i class="fa-solid fa-list"></i> Type Rumah
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/property_type_image') }}">
                <i class="fa-regular fa-image"></i> Gambar Property
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/testimonial') }}">
                <i class="fa-regular fa-thumbs-up"></i> Testimoni
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/settings') }}">
                <i class="fa-solid fa-gear"></i> Settings
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="{{ url('/') }}" class="btn-logout" style="cursor: pointer; width: 100%;">
            Logout
        </a>
    </div>
</div>
