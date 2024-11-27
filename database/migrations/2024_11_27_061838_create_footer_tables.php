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
        Schema::create('footer_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_name', 255);
            $table->string('title', 255)->nullable();
            $table->integer('position')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('footer_items', function(Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('footer_sections', 'id')->onDelete('cascade');
            $table->text('content')->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->integer('position')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_items');
        Schema::dropIfExists('footer_sections');
    }
};
