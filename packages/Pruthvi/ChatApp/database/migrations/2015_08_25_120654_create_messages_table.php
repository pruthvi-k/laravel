<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('body');

            $table->integer('chat_room_id')->unsigned();
            $table->integer('chat_room_id')
                ->references('id')
                ->on('chat_rooms')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->integer('user_id')->unsigned();
            $table->integer('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

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
        Schema::table('messages', function (Blueprint $table) {
            //
        });
    }
}
