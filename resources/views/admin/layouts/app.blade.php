<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Property</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #2b2b2b;
            --sidebar-header: #5cb85c;
            --sidebar-text: #ffffff;
            --sidebar-hover: #1a1a1a;
            --main-bg: #f5f5f5;
            --topbar-bg: #e0e0e0;
            --primary-green: #31743a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: var(--main-bg);
            overflow-x: hidden;
        }

        /* Layout Main */
        .main-wrapper {
            display: flex;
            width: 100%;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: calc(100% - 250px);
            transition: 0.3s;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            background-color: #ffffff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                width: 100%;
            }
            .sidebar-overlay.active {
                display: block;
            }
            .topbar-toggle {
                display: block !important;
            }
            .dashboard-container {
                padding: 20px !important;
            }
            .stat-grid {
                grid-template-columns: 1fr !important;
            }
            .featured-container {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        @include('admin.layouts.sidebar')

        <div class="main-content" id="mainContent">
            @include('admin.layouts.navbar')

            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }
    </script>
</body>
</html>
