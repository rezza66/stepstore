<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('prduct_transactions', 'product_transactions');
    }

    public function down(): void
    {
        Schema::rename('product_transactions', 'prduct_transactions');
    }
};
