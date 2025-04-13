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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id(); // id: bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY
            $table->unsignedBigInteger('created_by'); // created_by: bigint(20) unsigned NOT NULL
            $table->unsignedBigInteger('parent_id'); // parent_id: bigint(20) unsigned NOT NULL
            $table->unsignedBigInteger('child_id'); // child_id: bigint(20) unsigned NOT NULL
            $table->timestamps(); // created_at & updated_at

            // Indexes
            $table->index('created_by'); // Index for created_by
            $table->index('parent_id'); // Index for parent_id
            $table->index('child_id'); // Index for child_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
