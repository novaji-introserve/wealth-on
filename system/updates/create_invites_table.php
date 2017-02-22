<?php

namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateInvitesTable extends Migration {

    public function up() {
        Schema::create('wealthon_system_invites', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50)->nullable();
            $table->string('email', 100);
            $table->integer('user_id');
            $table->integer('package_id')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('wealthon_system_invites');
    }

}
