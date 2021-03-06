<?php namespace Wealthon\System\Models;

use Model;

/**
 * StoreType Model
 */
class StoreType extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_store_types';

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
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}