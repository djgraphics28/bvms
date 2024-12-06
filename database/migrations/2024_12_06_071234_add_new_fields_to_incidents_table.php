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
        Schema::table('incidents', function (Blueprint $table) {
            $table->string('contact_number', 20)->nullable();
            $table->string('reporter', 100)->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->string('email', 100)->nullable();
            $table->timestamp('date_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn(['contact_number', 'reporter', 'email', 'date_time']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
