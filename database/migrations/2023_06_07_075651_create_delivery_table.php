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
        Schema::create('delivery', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('fname');
            $table->string('lname');
            $table->bigInteger('phone');
            $table->string('street');
            $table->integer('flat');
            $table->string('city');
            $table->string('country');
            $table->bigInteger('postcode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
