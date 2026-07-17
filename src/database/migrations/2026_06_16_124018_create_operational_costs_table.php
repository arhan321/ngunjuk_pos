<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('operational_costs')) {
            Schema::create('operational_costs', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('category')->default('other');
                $table->unsignedInteger('amount')->default(0);
                $table->date('cost_date');
                $table->boolean('is_active')->default(true);
                $table->text('note')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_costs');
    }
};