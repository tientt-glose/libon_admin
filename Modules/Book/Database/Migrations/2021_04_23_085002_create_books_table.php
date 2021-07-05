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
            $table->id();
            $table->string('name', 150)->unique();
            $table->foreignId('publisher_id');
            $table->integer('page_number');
            $table->text('content_summary');
            $table->string('author', 50);
            $table->tinyInteger('can_borrow')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('borrowed')->default(0);
            $table->string('pic_link', 250);
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
        Schema::dropIfExists('books');
    }
}
