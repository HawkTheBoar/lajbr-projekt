<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#7e22ce',
                            light: '#a855f7',
                            dark: '#6b21a8',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style type="text/css">
        @layer components {
            /* Button Components */
            .btn-primary {
                @apply px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors;
            }

            .btn-secondary {
                @apply px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors;
            }

            .btn-danger {
                @apply px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors;
            }

            /* Badge Components */
            .badge {
                @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
            }

            .badge-primary {
                @apply bg-primary-light text-white;
            }

            .badge-success {
                @apply bg-green-100 text-green-800;
            }

            .badge-warning {
                @apply bg-yellow-100 text-yellow-800;
            }

            /* Text Utilities */
            .line-clamp-1 {
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Sidebar Components */
            .sidebar-link {
                @apply block py-3 px-4 rounded-lg transition-all duration-200;
            }

            .sidebar-section {
                @apply text-xs font-semibold uppercase tracking-wider text-purple-300 pl-4 pb-1 mt-4;
            }

            .sidebar-subitem {
                @apply py-2 px-6 rounded-lg transition-all duration-200;
            }

            .nav-active {
                @apply bg-white text-primary font-medium shadow-md;
            }

            /* Table Components */
            .table-header {
                @apply px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
            }

            .table-cell {
                @apply px-6 py-4 whitespace-nowrap text-sm text-gray-500;
            }

            /* Pagination */
            .pagination {
                @apply flex items-center space-x-1;
            }

            .page-item {
                @apply px-3 py-1 rounded-md;
            }

            .page-item.active {
                @apply bg-primary text-white;
            }

            .page-item:not(.active):not(.disabled) {
                @apply text-gray-700 hover:bg-gray-200;
            }

            .page-item.disabled {
                @apply text-gray-400 cursor-not-allowed;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-primary to-primary-dark p-4 text-white">
            <div class="p-4 border-b border-purple-400/30">
                <h1 class="text-xl font-bold flex items-center">
                    <i class="fas fa-cog mr-2"></i> Admin Panel
                </h1>
            </div>

            <nav class="mt-6 space-y-1">
                <!-- Dashboard Link - Emphasized -->
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link bg-white text-primary font-bold flex items-center nav-active">
                    <i class="fas fa-chart-bar mr-3"></i> Admin Dashboard
                </a>

                <!-- Create Section -->
                <div class="sidebar-section">
                    <i class="fas fa-plus-circle mr-2"></i> Create
                </div>

                <!-- Categories -->
                <a href="{{ route('admin.categories.create') }}"
                   class="sidebar-subitem flex items-center text-purple-100 hover:bg-purple-700/50">
                    <i class="fas fa-tag mr-3"></i> Categories
                </a>

                <!-- Products -->
                <a href="{{ route('admin.products.create') }}"
                   class="sidebar-subitem flex items-center text-purple-100 hover:bg-purple-700/50">
                    <i class="fas fa-box mr-3"></i> Products
                </a>

                <!-- Manage Section -->
                <div class="sidebar-section">
                    <i class="fas fa-database mr-2"></i> Manage
                </div>

                <!-- All Categories -->
                <a href="{{ route('admin.categories.create') }}"
                   class="sidebar-subitem flex items-center text-purple-100 hover:bg-purple-700/50">
                    <i class="fas fa-list mr-3"></i> All Categories
                </a>

                <!-- All Products -->
                <a href="{{ route('admin.products.create') }}"
                   class="sidebar-subitem flex items-center text-purple-100 hover:bg-purple-700/50">
                    <i class="fas fa-boxes mr-3"></i> All Products
                </a>
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 w-56 mx-4 mb-6">
                <a href="#" class="sidebar-link bg-purple-800/40 hover:bg-purple-800 flex items-center">
                    <i class="fas fa-sign-out-alt mr-3"></i> Logout
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow p-6">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Highlight current page in sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar-link, .sidebar-subitem');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('bg-purple-700/50', 'text-white');
                    link.classList.remove('text-purple-100', 'hover:bg-purple-700/50');

                    // Add icon indication
                    const icon = link.querySelector('i');
                    if (icon) {
                        icon.classList.add('text-purple-300');
                    }
                }
            });

            // Special case for dashboard
            if (currentPath.includes('dashboard')) {
                document.querySelector('.nav-active').classList.add('bg-white', 'text-primary', 'shadow-md');
            }
        });
    </script>
</body>
</html>
