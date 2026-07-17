<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('product_sizes', 'hpp_description')) {
            Schema::table('product_sizes', function (Blueprint $table): void {
                $table->text('hpp_description')->nullable()->after('hpp');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('product_sizes', 'hpp_description')) {
            Schema::table('product_sizes', function (Blueprint $table): void {
                $table->dropColumn('hpp_description');
            });
        }
    }
};
