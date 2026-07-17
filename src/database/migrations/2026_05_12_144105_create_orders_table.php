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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_code')->unique();

            $table->unsignedInteger('total_item')->default(0);
            $table->unsignedInteger('total_price')->default(0);

            $table->enum('status', [
                'Diproses',
                'Selesai',
                'Dibatalkan',
            ])->default('Selesai');

            $table->timestamp('ordered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
