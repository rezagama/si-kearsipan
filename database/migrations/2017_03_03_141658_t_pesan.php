<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TPesan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pesan', function(Blueprint $table){
          $table->increments('id');
          $table->char('id_pesan', 25)->unique();
          $table->char('id_pengirim', 25)->index();
          $table->char('id_penerima', 25)->index();
          $table->text('isi_pesan');
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
        Schema::drop('t_pesan');
    }
}
