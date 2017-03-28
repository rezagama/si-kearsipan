<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TArsip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_arsip', function (Blueprint $table) {
            $table->increments('id');
            $table->char('id_kategori', 25)->index();
            $table->char('id_user', 25)->index();
            $table->char('id_arsip', 25)->unique();
            $table->string('no_arsip', 50)->unique();
            $table->string('judul', 50);
            $table->date('jadwal_retensi');
            $table->text('deskripsi');
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
        Schema::drop('t_arsip');
    }
}
