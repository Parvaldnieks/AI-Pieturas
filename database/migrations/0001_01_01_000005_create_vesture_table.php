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
        Schema::create('vesture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pieturas_id')->constrained('pieturas')->onDelete('cascade');
            //$table->string('name');
            $table->string('text');
            $table->unsignedBigInteger('time')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vesture');
    }
};
