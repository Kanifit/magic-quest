<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_genres', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('genre_id');

            $table->foreign('book_id')
                ->references('id')
                ->on('books');

            $table->foreign('genre_id')
                ->references('id')
                ->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('book_terms', function (Blueprint $table) {
            $table->dropForeign('books_book_file_id_foreign');
            $table->dropForeign('books_lang_id_foreign');
        });*/

        Schema::dropIfExists('books_genres');
    }
}
