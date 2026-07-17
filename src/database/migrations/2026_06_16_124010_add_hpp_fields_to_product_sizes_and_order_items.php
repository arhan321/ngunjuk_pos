<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_sizes', function (Blueprint $table): void {
            if (! Schema::hasColumn('product_sizes', 'hpp')) {
                $table->unsignedInteger('hpp')->default(0)->after('price');
            }
        });

        Schema::table('order_items', function (Blueprint $table): void {
            if (! Schema::hasColumn('order_items', 'hpp')) {
                $table->unsignedInteger('hpp')->default(0)->after('price');
            }

            if (! Schema::hasColumn('order_items', 'total_hpp')) {
                $table->unsignedInteger('total_hpp')->default(0)->after('subtotal');
            }

            if (! Schema::hasColumn('order_items', 'gross_profit')) {
                $table->integer('gross_profit')->default(0)->after('total_hpp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table): void {
            if (Schema::hasColumn('order_items', 'gross_profit')) {
                $table->dropColumn('gross_profit');
            }

            if (Schema::hasColumn('order_items', 'total_hpp')) {
                $table->dropColumn('total_hpp');
            }

            if (Schema::hasColumn('order_items', 'hpp')) {
                $table->dropColumn('hpp');
            }
        });

        Schema::table('product_sizes', function (Blueprint $table): void {
            if (Schema::hasColumn('product_sizes', 'hpp')) {
                $table->dropColumn('hpp');
            }
        });
    }
};