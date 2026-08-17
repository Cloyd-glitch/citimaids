<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'bookings', callback: function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->string('property_type');          // apartment | villa | office
            $table->unsignedTinyInteger('rooms');
            $table->unsignedTinyInteger('bathrooms');
            $table->boolean('deep_clean')->default(false);
            $table->string('frequency')->default('onetime'); // onetime | weekly | biweekly | monthly

            $table->date('scheduled_date');
            $table->string('scheduled_time', 5); // "08:00"

            $table->text('address');
            $table->text('notes')->nullable();

            $table->decimal('total', 8, 2);
            $table->string('status')->default('pending'); // pending | confirmed | completed | cancelled
            $table->string('reference')->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'bookings');
    }
};