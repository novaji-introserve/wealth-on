<?php

namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddFieldsToProducts extends Migration {

    public function up() {
        Schema::table('feegleweb_octoshop_products', function($table) {
            $table->integer('owner_id')->unsigned()->index()->nullable();
            $table->decimal('selling_price',10,2);
        });
    }

    public function down() {
        Schema::table('users', function ($table) {
            $table->dropColumn(['package_id', 'parent_id', 'referral_id','generation_id','slot_id','is_director','store_enabled','is_root']);
        });
    }

}
