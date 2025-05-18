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
        Schema::table('pizzas', function (Blueprint $table) {
            Schema::table('pizzas', function (Blueprint $table) {
                $table->string('size')->after('name'); // môžeš zmeniť pozíciu podľa potreby
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            //
        });
    }
};
