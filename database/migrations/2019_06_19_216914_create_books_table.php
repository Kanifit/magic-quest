<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('book_title')->index();
            $table->string('version');
            $table->string('fb2_id');
            $table->text('text_index');
            $table->text('annotation')->nullable();
            $table->text('book_keywords')->nullable();
            $table->year('year_of_publishing')->nullable()->index();
            $table->string('city')->nullable();
            $table->string('isbn')->nullable()->index();
            $table->date('date_of_writing')->nullable()->index();
            $table->text('bibliographic_list')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lang_id');
            $table->unsignedBigInteger('publisher_id')->index();
            $table->text('cover_file');
            $table->unsignedBigInteger('book_file_id');
            $table->unsignedBigInteger('src_lang_id')->nullable();
            $table->boolean('available');
            $table->string('accent_color', 7)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('src_lang_id')
                ->references('id')
                ->on('langs');

            $table->foreign('lang_id')
                ->references('id')
                ->on('langs');

            $table->foreign('publisher_id')
                ->references('id')
                ->on('publishers');

            $table->foreign('book_file_id')
                ->references('id')
                ->on('files');
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
            $table->dropForeign('books_book_file_id_foreign');
            $table->dropForeign('books_lang_id_foreign');
            $table->dropForeign('books_publisher_id_foreign');
            $table->dropForeign('books_src_lang_id_foreign');
            $table->dropForeign('books_user_id_foreign');
        });

        Schema::dropIfExists('books');
    }
}
