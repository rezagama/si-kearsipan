<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TKategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kategori', function (Blueprint $table){
            $table->increments('id');
            $table->char('id_kategori', 25)->unique();
            $table->string('nama_kategori', 50);
            $table->tinyInteger('level_kategori');
            $table->char('parent', 25)->index();
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
        Schema::drop('t_kategori');
    }
}
