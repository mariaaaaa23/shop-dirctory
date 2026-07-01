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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

        $table->string('name');
        $table->string('slug')->unique();
        $table->unsignedBigInteger('cost');
        $table->string('image')->nullable();
        $table->text('description')->nullable();

        // کلیدهای خارجی اصلی
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('brand_id')->constrained()->onDelete('cascade');

        // ستون یوزرآیدی به صورت کاملاً Nullable
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
