<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('sales_targets')) {
            Schema::create('sales_targets', function (Blueprint $table): void {
                $table->id();
                $table->date('month')->unique();
                $table->unsignedInteger('target_revenue')->default(0);
                $table->unsignedInteger('target_gross_profit')->default(0);
                $table->unsignedInteger('target_net_profit')->default(0);
                $table->text('note')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_targets');
    }
};
