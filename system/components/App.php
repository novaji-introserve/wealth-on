<?php

namespace Wealthon\System\Components;

use Cms\Classes\ComponentBase;
use Wealthon\System\Models\Settings as WealthOn;
use Wealthon\System\Models\Member as Member;
use Wealthon\System\Models\Generation as Generation;
use Wealthon\System\Models\Package as Package;
use Wealthon\System\Models\Commission as Commission;
use Wealthon\System\Models\CommissionPlan as CommissionPlan;
use RainLab\User\Classes\AuthManager;

class App extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Application',
            'description' => 'Components for most Wealth-On functionality'
        ];
    }

    public function defineProperties() {
        return [];
    }

    public function getSettings() {
        return WealthOn::instance();
    }

    public function getPackagesOptions() {
        return Db::select('select id,name from wealthon_system_packages order by name asc');
    }

    public function getMember() {
        $auth = AuthManager::instance();
        $user = $auth->getUser();
        if ($user) {
            return Member::find($user->id);
        }
    }

    public function user() {
        return $this->getMember();
    }

    public function auth() {
        return AuthManager::instance();
    }

    public function onCheckEmail() {
        return ['isTaken' => $this->auth()->findUserByLogin(post('email')) ? 1 : 0];
    }

    public function settings() {
        return $this->getSettings();
    }

    public function getBankIdOptions() {
        $list = \Novaji\Bank\Models\Bank::orderBy('name', 'asc')->get();
        /*
          $listOptions = [];

          $list->each(function($item) use (&$listOptions) {
          $listOptions[$item->id] = $item->name;
          });
          return $listOptions;
         * 
         */
        return $list;
    }

    public function getAccountTypeIdOptions() {
        $list = \Novaji\Bank\Models\AccountType::orderBy('name', 'asc')->get();
        /*
          $listOptions = [];

          $list->each(function($item) use (&$listOptions) {
          $listOptions[$item->id] = $item->name;
          });
          return $listOptions;
         * 
         */
        return $list;
    }

}
