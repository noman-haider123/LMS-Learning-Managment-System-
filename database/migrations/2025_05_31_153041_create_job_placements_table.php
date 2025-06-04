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
      Schema::create('job_placements', function (Blueprint $table) {
            $table->id();
            $table->string("Student_Name");
            $table->text("Student_Review");
            $table->string("Student_Position");
            $table->string("Student_Image");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_placements');
    }
};
