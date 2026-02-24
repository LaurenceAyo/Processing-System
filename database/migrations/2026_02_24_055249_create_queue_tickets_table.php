<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('queue_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('counter_id')->nullable()->constrained()->nullOnDelete(); // assigned when serving starts
            $table->string('ticket_number', 20); // e.g. "DOC-001", "ENR-042"
            $table->integer('sequence_number'); // raw number for ordering (1, 2, 3...)
            $table->enum('status', ['waiting', 'serving', 'done', 'skipped'])->default('waiting');
            $table->timestamp('called_at')->nullable(); // when Next was clicked
            $table->timestamp('served_at')->nullable(); // when Done was clicked
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queue_tickets');
    }
};
