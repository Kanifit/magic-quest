<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CascadeDeletion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('steps', function (Blueprint $table) {
            $table->dropForeign('steps_test_id_foreign');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('questions_step_id_foreign');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign('answers_question_id_foreign');
            $table->dropForeign('answers_next_step_id_foreign');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('next_step_id')->references('id')->on('steps')->onDelete('cascade');
        });
        Schema::table('step_description', function (Blueprint $table) {
            $table->dropForeign('step_description_step_id_foreign');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
        });
        Schema::table('step_files', function (Blueprint $table) {
            $table->dropForeign('step_files_step_id_foreign');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
        });
        Schema::table('attempts', function (Blueprint $table) {
            $table->dropForeign('attempts_test_id_foreign');
            $table->dropForeign('attempts_user_id_foreign');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('attempt_journal', function (Blueprint $table) {
            $table->dropForeign('attempt_journal_attempt_id_foreign');
            $table->dropForeign('attempt_journal_step_id_foreign');
            $table->foreign('attempt_id')->references('id')->on('attempts')->onDelete('cascade');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
