<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('website_info', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('content')->nullable();
            $table->string('facebook_link')->nullable(); 
            $table->string('logo_image')->nullable();
            $table->timestamps();
        });

        // Insert default record
        DB::table('website_info')->insert([
            'address' => '123 Example St',
            'phone' => '0123456789',
            'email' => 'info@example.com',
            'content' => 'Website content goes here',
            'facebook_link' => 'https://facebook.com',
            'logo_image' => '/images/logo.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_info');
    }
};
