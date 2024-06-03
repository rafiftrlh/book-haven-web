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
        Schema::create('condition_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('borrowing_id');
            $table->enum('condition', ['rusak', 'baik']);
            $table->timestamps();

            // Definisikan relasi
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('borrowing_id')->references('id')->on('borrowings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condition_books');
    }
};
