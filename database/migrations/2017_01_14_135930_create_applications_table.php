<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{

    public function __construct() {
        $this->setTablename("applications");
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        if (!Schema::hasTable($this->getTablename())) {
            Schema::create($this->getTablename(), function (Blueprint $table) {
                $table->increments('id');
                $table->char('token', 40);
                $table->string('app_name', 75);
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
