<?php namespace Wealthon\System\Components;

use Cms\Classes\ComponentBase;
use Wealthon\System\Models\Package;
use RainLab\User\Models\User;
use Wealthon\System\Components\App;
use Db;

class Packages extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Packages',
            'description' => 'Feature for packages on wealthon'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    
    function getAll(){
        /*
        return Db::select('select p.id,p.name,format(p.registration_fee,0) fee,p.registration_fee, '
                . 'format(p.sales_commission,0) sales_commission,'
                . 'p.insurance_benefit, format(p.max_introduction_commission,0) max_introduction_commission,'
                . 's.name online_store,s.points,s.products_monthly '
                . 'from wealthon_system_packages p,wealthon_system_store_types s where p.store_type_id=s.id '
                . 'order by p.registration_fee asc');
         * 
         */
        return Package::orderBy('registration_fee','asc')->get();
    }
    
    function getUpgradable(){
        $app = new App;
        $user = $app->user();
        $amt = $user->package->registration_fee;
        #dd($amt);
        return Package::where('registration_fee','>',$amt)->orderBy('registration_fee','asc')->get();
    }

}