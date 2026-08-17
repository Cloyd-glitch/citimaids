<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'services', callback: function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category'); // home | business | specialty
            $table->string('icon');     // heroicon name, e.g. heroicon-o-home
            $table->string('description');
            $table->decimal('base_rate', 8, 2); // AED per hour
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

         Schema::table(table: 'services', callback: function (Blueprint $table) {
            $table->json('features')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'services');
    }
};