<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration {

    public function __construct() {
        $this->setTablename('languages');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->getTablename())) {
            Schema::create($this->getTablename(), function (Blueprint $table) {
                $table->increments('id');
                $table->char('lang_code', 2);
                $table->string('lang_name', 45);
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
