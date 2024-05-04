<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approved_by');
            $table->unsignedBigInteger('borrowing_id');
            $table->dateTime('permission_date')->nullable();
            $table->string('status', 20);
            $table->timestamps();
            $table->softDeletes();

            // Define foreign key constraints
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('borrowing_id')->references('id')->on('borrowings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
