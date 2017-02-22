<?php

namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCommissionPlansTable extends Migration {

    public function up() {
        Schema::create('wealthon_system_commission_plans', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_package_id');
            $table->integer('parent_package_id');
            $table->integer('parent_generation_id');
            $table->decimal('pct', 5, 2);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('wealthon_system_commission_plans');
    }

}
