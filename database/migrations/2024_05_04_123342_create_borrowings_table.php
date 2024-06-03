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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->date('borrow_date')->default(now());
            $table->date('return_date')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('status', ['awaiting approval', 'disapprove', 'borrowed', 'returned', 'broken', 'lost', 'late', 'late and broken'])->default('awaiting approval');
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->date('permission_date')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
