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
        //
        // Remove payment_status from shipping table
        Schema::table('shipping', function (Blueprint $table) {
            $table->dropColumn('payment_status');

            $table->dropColumn('billing_total');
        });

        // Add payment_status to orders table after status
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        // Reverse the changes made in the up method
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });

        Schema::table('shipping', function (Blueprint $table) {
            $table->string('payment_status')->nullable()->after('status');

            $table->decimal('billing_total', 10, 2)->nullable()->after('status');
        });
    }
};
