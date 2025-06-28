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
            $table->string('lot_plan')->nullable();
            $table->string('title_document')->nullable();
            $table->string('tax_declaration')->nullable();
            $table->string('atn_ats')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'lot_plan',
                'title_document',
                'tax_declaration',
                'atn_ats',
            ]);
        });
    }
};
