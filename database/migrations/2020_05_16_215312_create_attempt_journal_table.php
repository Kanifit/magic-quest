<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttemptJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attempt_journal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('attempt_id')->references('id')->on('attempts');
            $table->unsignedBigInteger('attempt_id');
            $table->foreign('step_id')->references('id')->on('steps');
            $table->unsignedBigInteger('step_id');
            $table->integer('point')->default(0);
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
        Schema::dropIfExists('attempt_journal');
    }
}
