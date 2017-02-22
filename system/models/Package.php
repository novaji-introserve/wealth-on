<?php

namespace Wealthon\System\Models;

use Model;


/**
 * Package Model
 */
class Package extends Model {

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_packages';
    use \October\Rain\Database\Traits\Validation;
    public $rules = [
        'name' => 'required',
        'registration_fee' => 'required'
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [ 'members' => '\Wealthon\System\Models\Member',
        'member_commission_plans' => ['\Wealthon\System\Models\CommissionPlan', 'key' => 'user_package_id'],
        'parent_commission_plans' => ['\Wealthon\System\Models\ComissionPlan', 'key' => 'parent_package_id']];
    public $belongsTo = ['store_type'=>'\Wealthon\System\Models\StoreType'];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

     public static function getPackageIdOptions() {
        $packages = \Wealthon\System\Models\Package::all(['id', 'name']);
        $packagesOptions = [];

        $packages->each(function($package) use (&$packagesOptions) {
            $packagesOptions[$package->id] = $package->name;
        });

        return $packagesOptions;
    }
    public function getStoreTypeIdOptions() {
        $list = \Wealthon\System\Models\StoreType::all(['id', 'name']);
        $listOptions = [];

        $list->each(function($item) use (&$listOptions) {
            $listOptions[$item->id] = $item->name;
        });

        return $listOptions;
    }
    
}
