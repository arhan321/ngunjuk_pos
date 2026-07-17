<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('operational_cost_monthly_adjustments')) {
            return;
        }

        Schema::create('operational_cost_monthly_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operational_cost_id')
                ->constrained('operational_costs')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');

            $table->unsignedBigInteger('amount')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_deleted_for_month')->default(false);

            $table->timestamps();

            $table->unique(
                ['operational_cost_id', 'month', 'year'],
                'op_cost_month_adjustment_unique'
            );

            $table->index(['month', 'year'], 'op_cost_month_adjustment_period_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_cost_monthly_adjustments');
    }
};
