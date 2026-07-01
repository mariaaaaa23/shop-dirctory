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
        Schema::table('orders', function (Blueprint $table) {
            //نال ابل چون ممکنه کاربر تخفیف نداشته باشه
            $table->foreignId('coupon_id')->nullable()->after('user_id')->constrained('coupons')->onDelete('set null');

            //مبلغ تخفیف داده شده
            $table->unsignedBigInteger('discount_amount')->default(0)->after('total_amount');

            //مبلغ نهایی که به بانک ارسال میشه
            $table->unsignedBigInteger('final_amount')->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
