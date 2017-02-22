<?php

namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddFieldsToUsers extends Migration {

    public function up() {
        Schema::table('users', function($table) {
            $table->integer('package_id')->unsigned()->index()->nullable();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('referral_id')->unsigned()->index()->nullable();
            $table->integer('generation_id')->unsigned()->index()->nullable();
            $table->integer('slot_id')->unsigned()->index()->nullable();
            $table->integer('is_director')->unsigned()->index()->default(0);
            $table->integer('store_enabled')->unsigned()->index()->default(0);
            $table->integer('is_root')->unsigned()->default(0);
        });
    }

    public function down() {
        Schema::table('users', function ($table) {
            $table->dropColumn(['package_id', 'parent_id', 'referral_id','generation_id','slot_id','is_director','store_enabled','is_root']);
        });
    }

}
