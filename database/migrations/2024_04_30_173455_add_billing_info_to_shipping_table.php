<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shipping', function (Blueprint $table) {
            //
            $table->string('first_name')->after('user_id');
            $table->string('last_name')->after('first_name');
            
            
            $table->string('payment_status')->default('pending');
            $table->decimal('billing_total', 10, 2)->default(0.00);

            $table->unsignedBigInteger('shipping_method_id')->nullable();
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping', function (Blueprint $table) {
            //
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('payment_status');
            $table->dropColumn('billing_total');
            $table->dropForeign(['shipping_method_id']);
            $table->dropColumn('shipping_method_id');
        });
    }
};
