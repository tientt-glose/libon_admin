<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //todo admin
            $table->tinyInteger('admin');
            $table->string('id_card', 12);
            $table->string('fullname', 50);
            $table->string('email')->unique();
            $table->string('password');
            $table->date('dob')->default('1990-01-01');
            $table->tinyInteger('gender')->default(0);
            $table->string('phone');
            $table->foreignId('organization_id');
            $table->tinyInteger('career');
            $table->string('id_staff_student');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
