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
        Schema::create('featured_category_proprty_group', function (Blueprint $table) {
            $table->foreignId('featured_category_id')
              ->constrained('featured_categories','category_id')
              ->onDelete('cascade');

           // اتصال به id جدول گروه‌های ویژگی
            $table->foreignId('property_group_id')
              ->constrained('property_groups')
              ->onDelete('cascade');

            // تعیین کلید اصلی ترکیبی با نام سفارشی کوتاه برای جلوگیری از ارور دیتابیس
            $table->primary(['featured_category_id', 'property_group_id'], 'fc_pg_primary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_category_proprty_group');
    }
};
