<?php namespace Wealthon\System\Models;

use Model;

/**
 * Generation Model
 */
class Generation extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_generations';
    
    
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'generation' => 'required',
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
    public $hasMany = ['commission_plans'=>'\Wealthon\System\Models\CommissionPlan','key'=>'generation'];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}