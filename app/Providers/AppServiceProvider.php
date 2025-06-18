<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CartService;
use App\Models\Category;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        view()->composer('*', function ($view) {
            $cartService = app(CartService::class);
            $cartCount = $cartService->totalItems();
            $view->with('cartCount', $cartCount);
        });
        view()->composer('*', function ($view){
            $rootCategories = Category::whereNull('parent_id')->with('children')->get();
            $view->with('rootCategories', $rootCategories);
        });
    }
}
