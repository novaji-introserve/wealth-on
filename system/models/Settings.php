<?php
/**
 * Created by PhpStorm.
 * User: Lamin Sanneh
 * Date: 5/19/14
 * Time: 10:35 AM
 */

namespace Wealthon\System\Models;

use Model;
class Settings extends Model{

    public $implement = [
        'System.Behaviors.SettingsModel'
    ];

    public $settingsCode = 'wealthon_settings';

    public $settingsFields = 'fields.yaml';
} 