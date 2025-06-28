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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('developer')->nullable(); // Developer / Owner / Seller
            $table->boolean('featured')->default(false); // Checkbox / switch
            $table->string('city')->nullable(); // With autosuggest later
            $table->string('model_type')->nullable(); // Single Attached, etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'developer',
                'featured',
                'city',
                'model_type',
            ]);
        });
    }
};
