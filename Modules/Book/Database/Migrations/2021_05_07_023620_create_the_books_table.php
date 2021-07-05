<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTheBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('the_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id');
            $table->string('barcode', 50)->unique();
            $table->tinyInteger('status')->default(1);
            $table->year('publishing_year')->nullable();
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
        Schema::dropIfExists('the_books');
    }
}
