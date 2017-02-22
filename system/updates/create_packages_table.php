<?php

namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePackagesTable extends Migration {

    public function up() {
        Schema::create('wealthon_system_packages', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 30);
            $table->decimal('registration_fee', 10, 2);
            $table->decimal('max_introduction_commission', 13, 2)->nullable();
            $table->decimal('sales_commission', 13, 2)->nullable();
            $table->integer('store_type_id')->nullable();
            $table->text('insurance_benefit')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('wealthon_system_packages');
    }

}
