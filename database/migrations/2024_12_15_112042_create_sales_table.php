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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('Region');
            $table->string('Country');
            $table->string('Item Type');
            $table->string('Sales Channel');
            $table->string('Order Priority');
            $table->string('Order Date');
            $table->bigInteger('Order ID');
            $table->string('Ship Date');
            $table->integer('Units Sold');
            $table->decimal('Unit Price', 8, 2);
            $table->decimal('Unit Cost', 8, 2);
            $table->decimal('Total Revenue', 12, 2);
            $table->decimal('Total Cost', 12, 2);
            $table->decimal('Total Profit', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
