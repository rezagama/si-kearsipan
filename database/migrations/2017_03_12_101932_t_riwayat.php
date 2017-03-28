<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TRiwayat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('t_riwayat', function(Blueprint $table){
        $table->increments('id');
        $table->char('id_log', 25)->index();
        $table->char('id_arsip', 25)->index();
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
      Schema::drop('t_riwayat');
    }
}
