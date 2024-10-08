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
        Schema::create('task_list_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_list_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('can_update')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->string('token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->foreign('task_list_id')->references('id')->on('task_lists')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_list_permissions');
    }
};
