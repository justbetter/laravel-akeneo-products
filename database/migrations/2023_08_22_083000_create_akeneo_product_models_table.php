<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akeneo_product_models', function (Blueprint $table): void {
            $table->id();
            $table->string('code');
            $table->boolean('synchronize')->default(true);
            $table->boolean('retrieve')->default(false);
            $table->boolean('update')->default(false);
            $table->integer('fail_count')->default(0);
            $table->json('data');
            $table->string('checksum')->nullable();
            $table->timestamp('retrieved_at')->nullable();
            $table->timestamp('modified_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akeneo_product_models');
    }
};
