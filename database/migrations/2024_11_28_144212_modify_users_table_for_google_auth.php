<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change(); // Make 'name' nullable
            $table->string('password')->nullable()->change(); // Make 'password' nullable
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change(); // Revert 'name' to NOT NULL
            $table->string('password')->nullable(false)->change(); // Revert 'password' to NOT NULL
        });
    }
};
