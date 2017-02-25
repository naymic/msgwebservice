<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVMessagesTable extends Migration {
    public  function __construct() {
        $this->setTablename('v_messages');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        DB::statement('CREATE VIEW  '. $this->getTablename() .'
        AS select `msg`.`idmsg` AS `idmsg`,`m`.`applications_id` AS `appid`,`msg`.`modules_id` AS `modid`,`l`.`lang_code` AS `lang`,`msg`.`message` AS `message`,`mt`.`type` AS `type` from ((((`messages` `msg` join `message_types` `mt` on((`msg`.`message_types_id` = `mt`.`id`))) join `languages` `l` on((`msg`.`languages_id` = `l`.`id`))) join `modules` `m` on((`msg`.`modules_id` = `m`.`id`))) join `applications` `a` on((`m`.`applications_id` = `a`.`id`)))
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS '. $this->getTablename());
    }
}
