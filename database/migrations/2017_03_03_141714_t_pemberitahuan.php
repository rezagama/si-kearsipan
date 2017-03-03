<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TPemberitahuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pemberitahuan', function(Blueprint $table){
          $table->increments('id');
          $table->char('id_user', 25)->index();
          $table->char('id_pemberitahuan', 25)->unique();
          $table->text('isi_pemberitahuan');
          $table->string('url', 255);
          $table->tinyInteger('status');
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
        Schema::drop('t_pemberitahuan');
    }
}
