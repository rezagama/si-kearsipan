<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TStatistik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_statistik', function(Blueprint $table){
          $table->increments('id');
          $table->char('id_arsip', 25)->index();
          $table->char('id_statistik', 25)->unique();
          $table->integer('jumlah_akses');
          $table->integer('jumlah_unduh');
          $table->integer('jumlah_cetak');
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
        Schema::drop('t_statistik');
    }
}
