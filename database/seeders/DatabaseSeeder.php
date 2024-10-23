<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\UserAddress;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
use Database\Factories\BrandFactory;
use Database\Factories\OrderFactory;
use Database\Factories\PaymentFactory;
use Database\Factories\ProductFactory;
use Database\Factories\CartItemFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OrderItemFactory;
use Database\Factories\UserAddressFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() < 5) {
            $this->call(UserFactory::class);
        }

        if (Brand::count() < 5) {
            $this->call(BrandFactory::class);
        }

        if (CartItem::count() < 5) {
            $this->call(CartItemFactory::class);
        }

        if (Category::count() < 5) {
            $this->call(CategoryFactory::class);
        }

        if (Order::count() < 5) {
            $this->call(OrderFactory::class);
        }

        if (OrderItem::count() < 5) {
            $this->call(OrderItemFactory::class);
        }

        if (Payment::count() < 5) {
            $this->call(PaymentFactory::class);
        }

        if (Product::count() < 5) {
            $this->call(ProductFactory::class);
        }

        if (UserAddress::count() < 5) {
            $this->call(UserAddressFactory::class);
        }

    }
}
