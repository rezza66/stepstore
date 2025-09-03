<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            // Cek & tambahin kolom yang hilang

            if (!Schema::hasColumn('product_transactions', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('product_transactions', 'phone')) {
                $table->string('phone')->after('name');
            }
            if (!Schema::hasColumn('product_transactions', 'email')) {
                $table->string('email')->after('phone');
            }
            if (!Schema::hasColumn('product_transactions', 'booking_trx_id')) {
                $table->string('booking_trx_id')->unique()->after('email');
            }
            if (!Schema::hasColumn('product_transactions', 'city')) {
                $table->string('city')->after('booking_trx_id');
            }
            if (!Schema::hasColumn('product_transactions', 'post_code')) {
                $table->string('post_code')->after('city');
            }
            if (!Schema::hasColumn('product_transactions', 'address')) {
                $table->text('address')->after('post_code');
            }
            if (!Schema::hasColumn('product_transactions', 'quantity')) {
                $table->unsignedInteger('quantity')->after('address');
            }
            if (!Schema::hasColumn('product_transactions', 'sub_total_amount')) {
                $table->decimal('sub_total_amount', 12, 2)->after('quantity');
            }
            if (!Schema::hasColumn('product_transactions', 'grand_total_amount')) {
                $table->decimal('grand_total_amount', 12, 2)->after('sub_total_amount');
            }
            if (!Schema::hasColumn('product_transactions', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)->default(0)->after('grand_total_amount');
            }
            if (!Schema::hasColumn('product_transactions', 'is_paid')) {
                $table->boolean('is_paid')->default(false)->after('discount_amount');
            }
            if (!Schema::hasColumn('product_transactions', 'shoe_id')) {
                $table->foreignId('shoe_id')->constrained()->cascadeOnDelete()->after('is_paid');
            }
            if (!Schema::hasColumn('product_transactions', 'shoe_size')) {
                $table->unsignedInteger('shoe_size')->after('shoe_id');
            }
            if (!Schema::hasColumn('product_transactions', 'promo_code_id')) {
                $table->foreignId('promo_code_id')->nullable()->constrained()->nullOnDelete()->after('shoe_size');
            }
            if (!Schema::hasColumn('product_transactions', 'proof')) {
                $table->string('proof')->nullable()->after('promo_code_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            // Drop kolom (hati-hati kalau sudah ada data)
            if (Schema::hasColumn('product_transactions', 'name')) $table->dropColumn('name');
            if (Schema::hasColumn('product_transactions', 'phone')) $table->dropColumn('phone');
            if (Schema::hasColumn('product_transactions', 'email')) $table->dropColumn('email');
            if (Schema::hasColumn('product_transactions', 'booking_trx_id')) $table->dropColumn('booking_trx_id');
            if (Schema::hasColumn('product_transactions', 'city')) $table->dropColumn('city');
            if (Schema::hasColumn('product_transactions', 'post_code')) $table->dropColumn('post_code');
            if (Schema::hasColumn('product_transactions', 'address')) $table->dropColumn('address');
            if (Schema::hasColumn('product_transactions', 'quantity')) $table->dropColumn('quantity');
            if (Schema::hasColumn('product_transactions', 'sub_total_amount')) $table->dropColumn('sub_total_amount');
            if (Schema::hasColumn('product_transactions', 'grand_total_amount')) $table->dropColumn('grand_total_amount');
            if (Schema::hasColumn('product_transactions', 'discount_amount')) $table->dropColumn('discount_amount');
            if (Schema::hasColumn('product_transactions', 'is_paid')) $table->dropColumn('is_paid');
            if (Schema::hasColumn('product_transactions', 'shoe_id')) $table->dropConstrainedForeignId('shoe_id');
            if (Schema::hasColumn('product_transactions', 'shoe_size')) $table->dropColumn('shoe_size');
            if (Schema::hasColumn('product_transactions', 'promo_code_id')) $table->dropConstrainedForeignId('promo_code_id');
            if (Schema::hasColumn('product_transactions', 'proof')) $table->dropColumn('proof');
        });
    }
};
