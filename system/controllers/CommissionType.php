<?php namespace Wealthon\System\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Commission Type Back-end Controller
 */
class CommissionType extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Wealthon.System', 'system', 'commissiontype');
    }
}