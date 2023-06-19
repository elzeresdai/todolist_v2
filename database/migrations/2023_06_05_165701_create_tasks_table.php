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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('todo_id')->constrained(
                'to_do_lists','id')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->string('task');
            $table->boolean('completed')->default(false);
            $table->boolean('previously_completed')->default(false);
            $table->timestamp('deadline')->nullable();
            $table->boolean('disabled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('tasks')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropForeign('todo_id');
            });
            Schema::dropIfExists('tasks');
        }
    }
};
