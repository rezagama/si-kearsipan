<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TPengumuman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pengumuman', function(Blueprint $table){
          $table->increments('id');
          $table->char('id_user', 25)->index();
          $table->char('id_pengumuman', 25)->unique();
          $table->string('judul_pengumuman', 50);
          $table->text('isi_pengumuman');
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
        Schema::drop('t_pengumuman');
    }
}
