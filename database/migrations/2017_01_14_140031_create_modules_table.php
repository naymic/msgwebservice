<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration {

    public  function __construct() {
        $this->setTablename('modules');
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
                $table->string('modul_name', 45);
                $table->foreign('applications_id')->references('id')->on('applications');
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
