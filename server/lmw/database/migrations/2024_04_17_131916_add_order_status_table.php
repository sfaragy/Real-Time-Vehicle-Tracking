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
       Schema::create('order_status', function (Blueprint $table) {
          $table->id();
          $table->uuid('order_id');
          $table->uuid('driver_id')->nullable();
          $table->enum('status', ['Initiated', 'Assigned', 'Delivered', 'Cancelled'])->default('Initiated');
          $table->timestamps();
          $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
          $table->foreign('driver_id')->references('id')->on('drivers');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status');
    }
};
