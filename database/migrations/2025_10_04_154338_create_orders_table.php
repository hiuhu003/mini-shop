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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pickup_station_id')->nullable()->constrained('pickup_stations')->nullOnDelete();
            $table->string('status')->default('pending');
            $table->string('payment_method');             
            $table->string('mpesa_phone')->nullable();
            $table->string('card_last4', 4)->nullable();

            $table->unsignedInteger('items_count')->default(0);
            $table->unsignedBigInteger('subtotal')->default(0);     
            $table->unsignedBigInteger('delivery_fee')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
