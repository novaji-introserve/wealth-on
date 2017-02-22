<?php namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateGenerationsTable extends Migration
{
    public function up()
    {
        Schema::create('wealthon_system_generations', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('generation')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wealthon_system_generations');
    }
}
