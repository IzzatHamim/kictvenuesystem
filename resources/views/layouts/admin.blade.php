{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - KICT Venues')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* Sidebar */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            transition: all 0.3s;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 999;
        }

        #sidebar.active {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
        }

        #sidebar .sidebar-header h3 {
            font-size: 1.3rem;
            font-weight: bold;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li {
            padding: 10px 0;
        }

        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 1rem;
            display: block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }

        #sidebar ul li a:hover,
        #sidebar ul li a.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #fff;
            padding-left: 16px;
        }

        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
        }

        /* Content */
        #content {
            width: 100%;
            padding: 0;
            min-height: 100vh;
            transition: all 0.3s;
            margin-left: var(--sidebar-width);
        }

        #content.active {
            margin-left: 0;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-navbar .btn-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--primary-color);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-menu img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Main Content Area */
        .main-content {
            padding: 30px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                margin-left: 0;
            }
            #content.active {
                margin-left: var(--sidebar-width);
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="bi bi-building"></i> KICT Admin</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.venues.index') }}" class="{{ request()->routeIs('admin.venues.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i> Manage Venues
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-calendar-check"></i> Bookings
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-people"></i> Users
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-graph-up"></i> Reports
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}">
                        <i class="bi bi-house-door"></i> Back to Website
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <button type="button" id="sidebarCollapse" class="btn-toggle">
                    <i class="bi bi-list"></i>
                </button>

                <div class="user-menu">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        document.getElementById('sidebarCollapse').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
    </script>
</body>
</html>