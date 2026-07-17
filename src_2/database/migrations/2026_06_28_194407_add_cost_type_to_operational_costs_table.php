<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('operational_costs')) {
            return;
        }

        if (! Schema::hasColumn('operational_costs', 'cost_type')) {
            Schema::table('operational_costs', function (Blueprint $table): void {
                $table
                    ->string('cost_type', 20)
                    ->default('monthly')
                    ->after('category');
            });
        }

        DB::table('operational_costs')
            ->where('category', 'rent')
            ->update(['cost_type' => 'annual']);

        DB::table('operational_costs')
            ->where(function ($query): void {
                $query
                    ->whereNull('cost_type')
                    ->orWhere('cost_type', '');
            })
            ->update(['cost_type' => 'monthly']);
    }

    public function down(): void
    {
        if (! Schema::hasTable('operational_costs')) {
            return;
        }

        if (Schema::hasColumn('operational_costs', 'cost_type')) {
            Schema::table('operational_costs', function (Blueprint $table): void {
                $table->dropColumn('cost_type');
            });
        }
    }
};
