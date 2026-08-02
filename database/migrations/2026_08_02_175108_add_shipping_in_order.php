<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_line1');
            $table->string('shipping_line2')->nullable();
            $table->string('shipping_postal_code');
            $table->string('shipping_city');
            $table->string('shipping_country');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_line1');
            $table->dropColumn('shipping_line2');
            $table->dropColumn('shipping_postal_code');
            $table->dropColumn('shipping_city');
            $table->dropColumn('shipping_country');
        });
    }
};
