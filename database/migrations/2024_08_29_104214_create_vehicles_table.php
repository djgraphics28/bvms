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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('model');
            $table->string('color');
            $table->string('brand');
            $table->string('photo')->nullable();
            $table->string('plate_number');
            $table->enum('status',['working','for-maintenance','not-working'])->default('working');
            $table->unsignedBigInteger('barangay_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
