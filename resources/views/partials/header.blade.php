<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Start Navbar Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('dashboard') }}" class="nav-link" onclick="alertDemo('Dashboard')">
                    <i class="bi bi-house-door me-1"></i> Dashboard
                </a>
            </li>
        </ul>

        <!-- End Navbar Links -->
        <ul class="navbar-nav ms-auto">

            <!-- Fullscreen Toggle -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>

            <!-- User Menu Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="d-none d-md-inline">{{ auth()->user()->nama }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!-- User image -->
                    <li class="user-header text-bg-primary">
                        <p>
                            Super Administrator
                            <small>
                                Super Admin
                            </small>
                        </p>
                    </li>

                    <!-- Menu Footer-->
                    <li class="user-footer d-flex justify-content-between">
                        <a href="#" class="btn btn-primary btn-sm" onclick="alertDemo('Profile')">
                            <i class="bi bi-person"></i> Profile
                        </a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="alertDemo('Logout')">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

@push('scripts')
    <script>
        function alertDemo(action) {
            Swal.fire({
                icon: 'info',
                title: 'Mode Demo',
                text: `Fitur "${action}" adalah demo. Data tidak akan berubah.`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        }
    </script>
@endpush

@push('styles')
    <style>
        .user-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px;
            text-align: center;
        }

        .user-header p {
            color: white;
            margin: 0;
            font-size: 16px;
        }

        .user-header p small {
            display: block;
            font-size: 12px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .user-footer {
            padding: 12px 15px;
            background-color: #f8f9fa;
        }

        .user-footer .btn {
            padding: 5px 15px;
            font-size: 13px;
        }

        .dropdown-menu {
            min-width: 200px;
        }
    </style>
@endpush