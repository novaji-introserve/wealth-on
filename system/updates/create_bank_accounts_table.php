<?php namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBankAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('wealthon_system_bank_accounts', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',200)->nullable();
            $table->string('account_number',30)->unique();
            $table->integer('bank_id');
            $table->integer('account_type_id');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wealthon_system_bank_accounts');
    }
}
