<?php

namespace Wealthon\System\Updates;

use Db;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Wealthon\System\Models\Package;
use Wealthon\System\Models\Generation;
use October\Rain\Database\Updates\Seeder;
use Wealthon\System\Models\Settings as Setup;

class SeedDatabase extends Seeder {

    public function run() {
        Package::create(['name' => 'Associate', 'registration_fee' => 5000]);
        Package::create(['name' => 'Bronze', 'registration_fee' => 10000]);
        Package::create(['name' => 'Silver', 'registration_fee' => 20000]);
        Package::create(['name' => 'Gold', 'registration_fee' => 50000]);

        for ($i = 1; $i <= Setup::get('max_generations'); $i++) {
            Generation::create(['generation' => $i]);
        }
        # styoe types
        Db::table('wealthon_system_store_types')->insert([
            ['name' => '1 Store (Personal Name) - 1 product/month', 'products_monthly' => 1, 'points' => 1],
            ['name' => '1 Store (Personal Name) - 2 products/month', 'products_monthly' => 2, 'points' => 2],
            ['name' => '1 Store (Personal/Corporate Name)', 'products_monthly' => 3, 'points' => 4],
            ['name' => '2 Store (Personal & Corporate Name)', 'products_monthly' => 0, 'points' => 10]
        ]);
         Db::table('wealthon_system_commission_types')->insert([
            ['name' => 'Member Registration','code'=>'REG'],
            ['name' => 'Product Sale','code'=>'SAL'],
        ]);
    }

}
