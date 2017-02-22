<?php

namespace Wealthon\System\Models;

use Model;

/**
 * CommissionPlan Model
 */
class CommissionPlan extends Model {

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_commission_plans';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'parent_generation_id' => 'required',
        'user_package_id' => 'required',
        'parent_package_id' => 'required',
        'pct' => 'required',
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
    public $hasMany = [];
    public $belongsTo = ['parent_generation' => ['\Wealthon\System\Models\Generation', 'key' => 'parent_generation_id', 'otherKey' => 'generation'],
        'member_package' => ['\Wealthon\System\Models\Package', 'key' => 'user_package_id'],
        'parent_package' => ['\Wealthon\System\Models\Package', 'key' => 'parent_package_id']];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getUserPackageIdOptions() {
        $packages = \Wealthon\System\Models\Package::all(['id', 'name']);
        $packagesOptions = [];

        $packages->each(function($package) use (&$packagesOptions) {
            $packagesOptions[$package->id] = $package->name;
        });

        return $packagesOptions;
    }

    public function getParentPackageIdOptions() {
        $packages = \Wealthon\System\Models\Package::all(['id', 'name']);
        $packagesOptions = [];

        $packages->each(function($package) use (&$packagesOptions) {
            $packagesOptions[$package->id] = $package->name;
        });

        return $packagesOptions;
    }

    public function getParentGenerationOptions() {
        $generations = \Wealthon\System\Models\Generation::all(['generation', 'generation']);
        $generationsOptions = [];

        $generations->each(function($generation) use (&$generationsOptions) {
            $generationsOptions[$generation->generation] = $generation->generation;
        });

        return $generationsOptions;
    }

}
