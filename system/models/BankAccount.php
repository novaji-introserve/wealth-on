<?php namespace Wealthon\System\Models;

use Model;

/**
 * BankAccount Model
 */
class BankAccount extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_bank_accounts';

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
    public $belongsTo = [
        'owner'=>['\Wealthon\System\Models\Member','key'=>'user_id'],
        'bank'=>['Novaji\Bank\Models\Bank','key'=>'bank_id'],
        'account_type'=>['Novaji\Bank\Models\Bank','key'=>'account_type_id'],
        ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}