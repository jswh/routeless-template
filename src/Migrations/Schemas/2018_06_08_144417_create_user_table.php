<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $blueprint) {
            $table = new Table($blueprint);
            $table->id();
            $table->string('username', '64')->unique();
            $table->string('email', 128)->unique();
            $table->string('mobile', 32)->unique();
            $table->string('password');
            $table->text('extra');
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
        //
    }
}
