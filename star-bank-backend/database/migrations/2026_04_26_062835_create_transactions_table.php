<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Auto Increment INT
            $table->string('account_id', 10);
            $table->enum('transaction_type', ['deposit', 'withdraw']);
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date');
            $table->decimal('interest_amount', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
