<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->unsignedBigInteger('question_id');
            $table->unsignedInteger('sort')->default(1000);
            $table->integer('point')->default(0);
            $table->foreign('next_step_id')->references('id')->on('steps');
            $table->unsignedBigInteger('next_step_id')->nullable();
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
        Schema::dropIfExists('answers');
    }
}
