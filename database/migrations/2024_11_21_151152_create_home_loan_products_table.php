<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_loan_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->unique()->onDelete('cascade');
            $table->decimal('property_value', 15, 2);
            $table->decimal('down_payment', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_loan_products');
    }
};
