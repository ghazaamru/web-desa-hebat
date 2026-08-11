<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45); // Support IPv6
            $table->date('visit_date');
            $table->timestamps();

            $table->unique(['ip_address', 'visit_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
