<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable(); // ak máš prihlásených používateľov

        $table->string('name');
        $table->string('email');
        $table->string('phone')->nullable();
        $table->text('address');
        $table->text('note')->nullable();

        // Košík a cena
        $table->json('cart_data');
        $table->decimal('total_price', 8, 2);

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
