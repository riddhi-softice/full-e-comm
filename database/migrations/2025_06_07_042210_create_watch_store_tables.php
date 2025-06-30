<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('address_type')->nullable();  // home, billing, shipping, ofc ..etc
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('reseller_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('warranty_years')->nullable();
            $table->longtext('long_desc')->nullable();
            $table->longtext('additional_info')->nullable();
            $table->longtext('shipping_info')->nullable();
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->string('path');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->decimal('total', 10, 2);
            $table->enum('status', ['pending','processing','shipped','cancelled','partially_shipped','delivered','partially_delivered','payment_captured'])->default('pending');
            $table->string('payment_method');
            $table->string('order_num')->nullable();
            $table->string('currency')->nullable();
            $table->string('order_note')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('awb_code')->nullable();
            $table->string('shiprocket_shipment_id')->nullable();
            $table->string('shipment_status')->nullable();
            $table->string('shipment_tracking_history')->nullable();
            $table->timestamp('placed_at')->nullable();
            $table->timestamps();
        });

        // Schema::create('order_items', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('order_id')->constrained();
        //     $table->foreignId('product_id')->constrained();
        //     $table->foreignId('variant_id')->nullable()->constrained('product_variants');
        //     $table->integer('quantity');
        //     $table->decimal('price', 10, 2);
        //     $table->timestamps();
        // });
   
        // Schema::create('inventory_logs', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('product_id')->constrained();
        //     $table->foreignId('variant_id')->nullable()->constrained('product_variants');
        //     $table->enum('change_type', ['in', 'out', 'return']);
        //     $table->integer('quantity');
        //     $table->timestamps();
        // });

        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        Schema::create('common_settings', function (Blueprint $table) {
            $table->id();
            $table->text('setting_key')->nullable();
            $table->text('setting_value')->nullable();
            $table->text('data_comment')->nullable();
            $table->timestamps();
        });
       
        Schema::create('order_tracking', function (Blueprint $table) {
            $table->id();
            $table->text('setting_key')->nullable();
            $table->text('setting_value')->nullable();
            $table->text('data_comment')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('cat_id')->constrained();
            $table->text('image')->nullable();
            $table->timestamps();
        });
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('logo')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('return_requests');
        // Schema::dropIfExists('inventory_logs');
        // Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('users');
        Schema::dropIfExists('common_settings');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('brands');
    }
   

};