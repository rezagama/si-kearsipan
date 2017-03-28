<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TIsiPesan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_isi_pesan', function(Blueprint $table){
          $table->increments('id');
          $table->char('id_isi_pesan', 25)->unique();
          $table->char('id_pesan', 25)->index();
          $table->char('id_user', 25)->index();
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
        Schema::drop('t_isi_pesan');
    }
}
