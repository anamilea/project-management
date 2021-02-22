<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->tinyInteger('status')->default(0); //toDo, inProgress, Done
            $table->string('attachment')->nullable();
            $table->bigInteger('assignedTo')->unsigned();
            $table->bigInteger('project')->unsigned();
            $table->foreign('assignedTo')->references('id')->on('user');
            $table->foreign('project')->references('id')->on('project');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
}
