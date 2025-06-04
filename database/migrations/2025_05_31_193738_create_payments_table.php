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
      Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("Course_Id")->references('id')->on("courses")->onDelete('cascade');
            $table->string("Customer_Name");
            $table->string("Amount");
            $table->string("Currency");
            $table->string("Source");
            $table->string("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
