<?php namespace Wealthon\Store\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMemberStoresTable extends Migration
{
    public function up()
    {
        Schema::create('wealthon_store_stores', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name',30);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wealthon_store_stores');
    }
}
