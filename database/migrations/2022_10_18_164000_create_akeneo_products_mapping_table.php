<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akeneo_products_mappings', function (Blueprint $table): void {
            $table->id();
            $table->string('type');
            $table->string('source');
            $table->string('destination');
            $table->boolean('override')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akeneo_products_mappings');
    }
};
