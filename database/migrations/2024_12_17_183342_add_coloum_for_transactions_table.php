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
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('quantity')->after('amount');
            $table->string('payment_type')->nullable()->after('quantity');
            $table->string('payment_code')->nullable()->after('payment_type');
            $table->timestamp('payment_date')->nullable()->after('payment_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'quantity',
                'payment_type',
                'payment_code',
                'payment_date'
            ]);
        });
    }
};