<?php

use App\Enums\TaskStatus;
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
            $table->string('name', 100);
            $table->string('description', 255);
            $table->enum('status', TaskStatus::values())
                ->default(TaskStatus::Uncompleted->value)
                ->index();

            $table->foreignId('creator_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // $table->foreign('creator_id')->references('id')->on('users')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');

            // $table->foreignId('user_id')
            //     ->constrained()
            //     ->cascadeOnUpdate()
            //     ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
