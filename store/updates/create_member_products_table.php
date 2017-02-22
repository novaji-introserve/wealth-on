<?php

namespace Wealthon\Store\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMemberProductsTable extends Migration {

    public function up() {
        Schema::create('wealthon_store_member_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('wealthon_store_member_products');
    }

}
