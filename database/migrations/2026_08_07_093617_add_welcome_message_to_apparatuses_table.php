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
        Schema::table('apparatuses', function (Blueprint $table) {
            $table->text('welcome_message')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('apparatuses', function (Blueprint $table) {
            $table->dropColumn('welcome_message');
        });
    }
};
