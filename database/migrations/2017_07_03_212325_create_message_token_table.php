<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTokenTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if(!Schema::hasTable('messages_token')) {
            Schema::create('messages_token', function (Blueprint $table) {
                $table->increments('id');
                $table->smallInteger('idmsg');
                $table->string('token', 50);
                $table->foreign('messages_idmsg')->references('idmsg')->on('messages');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('messages_token');
    }
}
