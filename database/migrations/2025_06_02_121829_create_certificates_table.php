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
         Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId("Course_id")->references("id")->on("courses")->onDelete("cascade");
            $table->foreignId("Student_id")->references("id")->on("students")->onDelete("cascade");
            $table->string("Created_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
