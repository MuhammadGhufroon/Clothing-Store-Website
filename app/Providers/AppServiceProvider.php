<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Wishlist;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Menggunakan view composer untuk menyediakan cartItemCount dan wishlistItemCount ke semua views
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Hitung jumlah item dalam cart
                $cartItemCount = Order::where('customer_id', $user->id)
                    ->where('status', 'pending')
                    ->withCount('orderDetails')
                    ->get()
                    ->sum('order_details_count');

                // Hitung jumlah item dalam wishlist
                $wishlistItemCount = Wishlist::where('customer_id', $user->id)->count();
            } else {
                $cartItemCount = 0;
                $wishlistItemCount = 0;
            }

            // Mengirimkan kedua informasi ke semua tampilan
            $view->with('cartItemCount', $cartItemCount);
            $view->with('wishlistItemCount', $wishlistItemCount);
        });
    }
}
