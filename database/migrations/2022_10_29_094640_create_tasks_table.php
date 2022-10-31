<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // max 18_446_744_073_709_551_615
            $table->string('name', 64);

            $table->unsignedInteger('project_id');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedBigInteger('contractor_id');
            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedTinyInteger('priority_id');
            $table->foreign('priority_id')
                ->references('id')
                ->on('priorities')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedTinyInteger('status_id');
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->date('deadline')->nullable();
            $table->string('description')->nullable();
            // TODO: Оно так работает https://dev.mysql.com/doc/refman/8.0/en/date-and-time-functions.html#function_time? Если так, то это ошибка тип decimal нужен.
            $table->time('actual_time')->nullable();
            $table->boolean('is_accepted');
            $table->date('completed_at')->nullable();

            $table->timestamps();

            $table->unique(['project_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
