<?php namespace Wealthon\System\Models;

use Model;

/**
 * Commission Model
 */
class Commission extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_commissions';

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
    public $belongsTo = [ 'owner'    => '\RainLab\User\Models\User',
        'user'=>'\RainLab\User\Models\User',
        'plan'=>'\Wealthon\System\Models\CommissionPlan',
        'type'=>['\Wealthon\System\Models\CommissionType','key'=>'type_id']];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}