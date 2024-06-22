<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Using raw SQL to modify the enum column since the doctrine dbal change() doesn't support it
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'cancelled', 'delivered') DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Using raw SQL to modify the enum column since the doctrine dbal change() doesn't support it
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending'");
        });
    }
};
