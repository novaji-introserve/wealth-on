<?php namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCommissionTypesTable extends Migration
{
    public function up()
    {
        Schema::create('wealthon_system_commission_types', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 30);
            $table->string('code', 3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wealthon_system_commission_types');
    }
}
