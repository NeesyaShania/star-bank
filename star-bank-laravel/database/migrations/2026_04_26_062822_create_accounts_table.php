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
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('customer_id', 10);
            $table->string('deposito_type_id', 10);
            $table->decimal('balance', 15, 2)->default(0);
            $table->timestamps();

            // Relasi (Foreign Key)
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('deposito_type_id')->references('id')->on('deposito_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
