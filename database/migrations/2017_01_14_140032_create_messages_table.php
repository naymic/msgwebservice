<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

    public  function __construct() {
        $this->setTablename('messages');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
       if(!Schema::hasTable($this->getTablename())) {
           Schema::create($this->getTablename(), function (Blueprint $table) {
               $table->increments('id');
               $table->smallInteger('idmsg');
               $table->string('message', 200);
               $table->foreign('modules_id')->references('id')->on('modules');
               $table->foreign('languages_id')->references('id')->on('languages');
               $table->foreign('message_types_id')->references('id')->on('message_types');
           });
       }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTablename());
    }
}
