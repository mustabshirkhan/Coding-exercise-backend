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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount');
            $table->unsignedBigInteger('payer'); // Change to unsignedBigInteger for user_id
            $table->foreign('payer')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');; // Assuming 'users' is your users table
            $table->date('due_on');
            $table->decimal('vat');
            $table->boolean('is_vat_inclusive');
            $table->enum('status', ['Paid', 'Outstanding', 'Overdue'])->default('Outstanding');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
