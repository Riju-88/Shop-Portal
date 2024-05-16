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
        Schema::table('payment_methods', function (Blueprint $table) {
            //
            $table->renameColumn('name', 'pay_method_name');
            $table->renameColumn('description', 'pay_method_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            //
            $table->renameColumn('pay_method_name', 'name');
            $table->renameColumn('pay_method_description', 'description');
        });
    }
};
