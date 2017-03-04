<?php

namespace Wealthon\System\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddFieldsToProducts extends Migration {

    public function up() {
        Schema::table('feegleweb_octoshop_products', function($table) {
            $table->integer('owner_id')->unsigned()->index()->nullable();
            $table->decimal('selling_price',10,2)->nullable();
            $table->decimal('pct_sales_addon',10,2);
            $table->decimal('pct_vat',10,2);
        });
    }

    public function down() {
        Schema::table('feegleweb_octoshop_products', function ($table) {
            $table->dropColumn(['owner_id','pct_vat','pct_sales_addon','selling_price']);
        });
    }

}
