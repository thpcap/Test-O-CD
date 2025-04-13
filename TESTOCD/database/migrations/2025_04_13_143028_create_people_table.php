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
        Schema::create('people', function (Blueprint $table) {
            $table->id(); // id: bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY
            $table->unsignedBigInteger('created_by'); // created_by: bigint(20) unsigned NOT NULL
            $table->string('first_name'); // first_name: varchar(255) NOT NULL
            $table->string('last_name'); // last_name: varchar(255) NOT NULL
            $table->string('birth_name')->nullable(); // birth_name: varchar(255) DEFAULT NULL
            $table->string('middle_names')->nullable(); // middle_names: varchar(255) DEFAULT NULL
            $table->date('date_of_birth')->nullable(); // date_of_birth: date DEFAULT NULL
            $table->timestamps(); // created_at & updated_at

            // Indexes
            $table->index('created_by'); // Index for created_by
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
