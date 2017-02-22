<?php namespace Wealthon\System\Models;

use Model;

/**
 * CommissionType Model
 */
class CommissionType extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_commission_types';
    
    
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
    public $hasMany = ['commissions'=>'\Wealthon\System\Models\Commission'];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}