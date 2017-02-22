<?php namespace Wealthon\System\Models;

use Model;

/**
 * Referral Model
 */
class Referral extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_referrals';

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
    public $belongsTo = ['owner'=>'\Wealthon\System\Models\Member'];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}