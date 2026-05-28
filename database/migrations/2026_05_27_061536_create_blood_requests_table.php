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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->string('requester_name');
            $table->string('blood_group');
            $table->integer('units_needed')->default(1);
            $table->string('hospital');
            $table->string('city');
            $table->enum('urgency', ['normal', 'urgent'])->default('normal');
            $table->enum('status', ['pending', 'matched', 'fulfilled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
