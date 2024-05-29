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
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrowing_id');
            $table->enum('condition', ['broken', 'lost', 'late return']);
            $table->string('type', 20)->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Define foreign key constraints
            $table->foreign('borrowing_id')->references('id')->on('borrowings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
