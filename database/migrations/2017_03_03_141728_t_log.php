<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_log', function(Blueprint $table){
          $table->increments('id');
          $table->char('id_log', 25)->unique();
          $table->char('id_user', 25)->index();
          $table->text('deskripsi');
          $table->string('url', 255);
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
        Schema::drop('t_log');
    }
}
