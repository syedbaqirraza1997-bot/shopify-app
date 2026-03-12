<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Conversion Booster')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #008060;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f6f6f7;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            border-right: 1px solid #e1e3e5;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e1e3e5;
        }
        
        .sidebar-header h4 {
            margin: 0;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .nav-link {
            padding: 12px 20px;
            color: #5c5f62;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }
        
        .nav-link:hover {
            background: #f6f6f7;
            color: var(--primary-color);
        }
        
        .nav-link.active {
            background: #e3f1e8;
            color: var(--primary-color);
            border-right: 3px solid var(--primary-color);
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
        }
        
        .top-bar {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e1e3e5;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: #006e52;
            border-color: #006e52;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .stat-label {
            color: #5c5f62;
            font-size: 14px;
        }
        
        .badge-pending {
            background: #ffc453;
            color: #5c3d00;
        }
        
        .badge-approved {
            background: #a5e3b9;
            color: #0c5132;
        }
        
        .badge-rejected {
            background: #fec5c5;
            color: #8e1f0b;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-rocket"></i> Smart Conversion</h4>
        </div>
        
        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            
            <a href="{{ route('reviews') }}" class="nav-link {{ request()->routeIs('reviews') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Reviews
            </a>
            
            <a href="{{ route('popups') }}" class="nav-link {{ request()->routeIs('popups') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> Sales Popups
            </a>
            
            <a href="{{ route('social-proof') }}" class="nav-link {{ request()->routeIs('social-proof') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Social Proof
            </a>
            
            <a href="{{ route('trust-badges') }}" class="nav-link {{ request()->routeIs('trust-badges') ? 'active' : '' }}">
                <i class="fas fa-shield-alt"></i> Trust Badges
            </a>
            
            <a href="{{ route('urgency') }}" class="nav-link {{ request()->routeIs('urgency') ? 'active' : '' }}">
                <i class="fas fa-clock"></i> Urgency
            </a>
            
            <a href="{{ route('product-page') }}" class="nav-link {{ request()->routeIs('product-page') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Product Page
            </a>
            
            <a href="{{ route('import') }}" class="nav-link {{ request()->routeIs('import') ? 'active' : '' }}">
                <i class="fas fa-upload"></i> Import
            </a>
            
            <a href="{{ route('settings') }}" class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
            
            <div class="mt-auto">
                <a href="{{ route('auth.logout') }}" class="nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div>
                <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="ms-2">@yield('page-title', 'Dashboard')</span>
            </div>
            <div>
                <span class="text-muted">{{ session('shop_domain') }}</span>
            </div>
        </div>
        
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Page Content -->
        @yield('content')
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
    
    @yield('scripts')
</body>
</html>
