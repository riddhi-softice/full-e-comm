<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Type;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductMedia;
use App\Models\Coupon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderCoupon;
use App\Models\OrderStatusHistory;
use App\Models\Shipment;
use App\Models\Address;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'Admin'],
            ['name' => 'Customer'],
        ]);

        Type::insert([
            ['name' => 'Cloth'],
            ['name' => 'Market'],
            ['name' => 'Store'],
            ['name' => 'Fashion'],
        ]);

        Category::insert([
            ['name' => 'Dress', 'type_id' => 1],
            ['name' => 'T-Shirt', 'type_id' => 1],
        ]);

        SubCategory::insert([
            ['name' => 'Patiala', 'category_id' => 1],
            ['name' => 'Plaza', 'category_id' => 1],
        ]);

        Attribute::insert([
            ['name' => 'Color'],
            ['name' => 'Size'],
        ]);

        AttributeValue::insert([
            ['attribute_id' => 1, 'value' => 'Red'],
            ['attribute_id' => 1, 'value' => 'Blue'],
            ['attribute_id' => 2, 'value' => 'M'],
            ['attribute_id' => 2, 'value' => 'L'],
        ]);

        Brand::insert([
            ['name' => 'Nike'],
            ['name' => 'Adidas'],
        ]);

        Product::insert([
            [
                'name' => 'Casual Shirt',
                'type_id' => 1,
                'category_id' => 2,
                'sub_category_id' => 2,
                'brand_id' => 1,
                'description' => 'Cotton shirt',
                'price' => 999,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ProductVariant::insert([
            [
                'product_id' => 1,
                'sku' => 'SHIRT-RED-M',
                'stock' => 50,
                'price' => 999,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ProductMedia::insert([
            ['product_id' => 1, 'type' => 'image', 'url' => 'shirt.jpg'],
        ]);

        Coupon::insert([
            ['code' => 'WELCOME10', 'type' => 'percentage', 'value' => 10, 'is_active' => true],
        ]);

        Sale::insert([
            ['product_id' => 1, 'sale_price' => 899, 'start_date' => now(), 'end_date' => now()->addWeek()],
        ]);

        User::insert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '9876543210',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Address::insert([
            [
                'user_id' => 1,
                'line1' => '123 Street',
                'city' => 'Surat',
                'state' => 'Gujarat',
                'postal_code' => '395006',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Order::insert([
            [
                'user_id' => 1,
                'address_id' => 1,
                'status' => 'processing',
                'total' => 999,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        OrderItem::insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'product_variant_id' => 1,
                'quantity' => 1,
                'price' => 999,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        OrderCoupon::insert([
            ['order_id' => 1, 'coupon_id' => 1],
        ]);

        OrderStatusHistory::insert([
            ['order_id' => 1, 'status' => 'processing', 'changed_at' => now()],
        ]);

        Shipment::insert([
            ['order_id' => 1, 'tracking_number' => 'TRACK123', 'shipped_at' => now()],
        ]);
    }
}
