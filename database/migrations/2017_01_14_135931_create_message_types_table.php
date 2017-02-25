<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTypesTable extends Migration
{

    public function __construct() {
        $this->setTablename('message_types');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->getTablename())){
            Schema::create($this->getTablename(), function (Blueprint $table) {
                $table->increments('id');
                $table->string('type', 20);
                $table->string('name', 45);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists($this->getTablename());
    }
}
