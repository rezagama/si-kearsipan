<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('t_akun', function (Blueprint $table) {
          $table->increments('id');
          $table->char('id_user', 25)->unique();
          $table->char('nip', 18)->unique();
          $table->string('nama', 50);
          $table->string('email', 50)->unique();
          $table->string('no_hp', 15);
          $table->date('tgl_lahir');
          $table->tinyInteger('jenis_kelamin');
          $table->text('alamat');
          $table->string('password', 255);
          $table->string('avatar', 255);
          $table->enum('hak_akses', ['all']);
          $table->tinyInteger('level');
          $table->tinyInteger('status');
          $table->rememberToken();
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
        Schema::drop('t_akun');
    }
}
