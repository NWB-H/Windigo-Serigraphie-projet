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
        Schema::table('users', function (Blueprint $table): void {
            $table->string('reset_password_token')->nullable()->after('password');
            $table->timestamp('reset_password_token_expires_at')->nullable()->after('reset_password_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('reset_password_token');
            $table->dropColumn('reset_password_token_expires_at');
        });
    }
};
