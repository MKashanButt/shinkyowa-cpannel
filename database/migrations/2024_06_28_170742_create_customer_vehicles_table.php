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
        Schema::create('customer_vehicles', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('stock_id', 15);
            $table->string('vehicle', 100);
            $table->string('customer_email', 100);
            $table->string('status', 15);
            $table->enum('payment_status',[
                'cleared',
                'pending'
            ] );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_vehicles');
    }
};
