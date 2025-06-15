<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Catalogue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @layer components {
            .catalogue-card {
                @apply bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1;
            }
            .add-to-cart-btn {
                @apply w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white rounded-lg flex items-center justify-center transition-colors;
            }
            .category-card {
                @apply bg-white rounded-xl shadow p-4 transition-all hover:shadow-md;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <a href="{{ route('catalogue.index') }}">{{ config('app.name') }}</a>
                </h1>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-700 hover:text-purple-600">
                        <i class="fas fa-search"></i>
                    </a>
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-purple-600 relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute -top-2 -right-2 bg-purple-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            0
                        </span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div class="w-64 bg-white shadow-md p-4">
                <h2 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">Product Categories</h2>
                <ul class="space-y-2">
                    @foreach($rootCategories as $category)
                    <li>
                        <a href="{{ route('catalogue.category', $category) }}"
                           class="block py-2 px-3 rounded-lg hover:bg-purple-50 text-gray-700 hover:text-purple-700 font-medium">
                            {{ $category->title }}
                        </a>

                        @if($category->children->count() > 0)
                        <ul class="ml-4 mt-1 space-y-1">
                            @foreach($category->children as $child)
                            <li>
                                <a href="{{ route('catalogue.category', $child) }}"
                                   class="block py-1 px-3 rounded hover:bg-purple-50 text-sm text-gray-600 hover:text-purple-700">
                                    {{ $child->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Content Area -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white shadow-inner py-6 mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </footer>
    </div>

    <!-- Add to Cart Form -->
    <form id="add-to-cart-form" action="{{ route('cart.addproduct') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="product_id" id="cart_product_id">
        <input type="hidden" name="quantity" id="cart_quantity" value="1">
    </form>

    <script>
        function addToCart(productId) {
            document.getElementById('cart_product_id').value = productId;
            document.getElementById('add-to-cart-form').submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add to cart button handlers
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    addToCart(productId);
                });
            });
        });
    </script>
</body>
</html>
