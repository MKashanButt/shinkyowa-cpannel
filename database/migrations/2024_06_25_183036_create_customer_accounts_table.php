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
        Schema::create('customer_accounts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('customer_id', 100);
            $table->string('customer_name', 100);
            $table->string('customer_company', 200);
            $table->string('customer_phone', 15);
            $table->text('description')->nullable();
            $table->text('buying')->nullable();
            $table->text('deposit')->nullable();
            $table->text('remaining')->nullable();
            $table->string('agent_manager', 100);
            $table->integer('agent_id')->nullable();
            $table->string('customer_email', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_accounts');
    }
};
