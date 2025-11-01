<?php

use App\Enums\WorkshopEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', WorkshopEnum::values());
            $table->integer('price');
            $table->time('duration');
            $table->integer('age');
            $table->text('description')->nullable(); 
            $table->json('images')->nullable();    
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};

