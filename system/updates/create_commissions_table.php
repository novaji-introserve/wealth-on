<?php namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCommissionsTable extends Migration
{
    public function up()
    {
        Schema::create('wealthon_system_commissions', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('amount', 10, 2);
            $table->string('status', 30)->default('unpaid');
            $table->text('notes');
            $table->bigInteger('owner_id');
            $table->bigInteger('user_id');
            $table->integer('plan_id');
            $table->integer('type_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wealthon_system_commissions');
    }
}
