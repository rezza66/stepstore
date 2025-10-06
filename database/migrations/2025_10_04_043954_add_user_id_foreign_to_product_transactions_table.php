<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            // kalau kolom user_id belum ada, tambahin
            if (!Schema::hasColumn('product_transactions', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
        });

        // pastikan semua user_id null/0 diisi ke 1
        DB::table('product_transactions')
            ->whereNull('user_id')
            ->orWhere('user_id', 0)
            ->update(['user_id' => 1]);

        // tambahin foreign key
        Schema::table('product_transactions', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
