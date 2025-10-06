<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            // Ubah kolom shoe_size jadi string
            $table->string('shoe_size', 10)->change();
        });
    }

    public function down(): void
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            // Rollback ke integer kalau mau balik
            $table->unsignedInteger('shoe_size')->change();
        });
    }
};
