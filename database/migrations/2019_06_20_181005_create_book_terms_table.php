<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_terms', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('term_id');

            $table->foreign('book_id')
                ->references('id')
                ->on('books');

            $table->foreign('term_id')
                ->references('id')
                ->on('terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_terms', function (Blueprint $table) {
            $table->dropForeign('book_terms_book_id_foreign');
            $table->dropForeign('book_terms_term_id_foreign');
        });
        
        Schema::dropIfExists('book_terms');
    }
}
