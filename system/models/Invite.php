<?php

namespace Wealthon\System\Models;

use Model;

/**
 * Invite Model
 */
class Invite extends Model {

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wealthon_system_invites';

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
    public $belongsTo = [['owner' => '\Wealthon\System\Models\Member','key'=>'user_id'],
        'package' => 'Wealthon\System\Models\Package'];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
