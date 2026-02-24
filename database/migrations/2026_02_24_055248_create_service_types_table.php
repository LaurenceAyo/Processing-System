<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // e.g. "Document Request", "Enrollment"
            $table->string('code', 10);                   // e.g. "DOC", "ENR" — used as prefix for queue numbers
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);  // can deactivate a service without deleting
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_types');
    }
};
