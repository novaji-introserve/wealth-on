<?php

namespace Wealthon\System;

use Db;
use Backend;
use View;
use System\Classes\PluginBase;
use RainLab\User\Models\User;
use Wealthon\System\Models\Package;
use RainLab\User\Controllers\Users as UsersController;
use Wealthon\System\Models\Member as Member;
use Wealthon\System\Components\App;
use Wealthon\System\Models\Settings as AppSettings;

/**
 * system Plugin Information File
 */
class Plugin extends PluginBase {

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name' => 'Wealth-On',
            'description' => 'Wealth On Components',
            'author' => 'wealthon',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register() {
        
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot() {
        View::share('site_name', 'Wealth-On');
        User::extend(function($model) {
            $model->belongsTo['package'] = ['\Wealthon\System\Models\Package'];
            /*
              $model->belongsTo['parent'] = ['\Wealthon\System\Models\Member'];
              $model->belongsTo['referral'] = ['\Wealthon\System\Models\Member'];
             * 
             */
        });
        UsersController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof User) {
                return;
            }
            $form->addTabFields([

                'package_id' => [
                    'label' => 'Current Package',
                    'tab' => 'Wealth-On',
                    'span' => 'auto',
                    'type' => 'dropdown',
                    'options' => Package::getPackageIdOptions(),
                ],
                'parent_id' => [
                    'label' => 'Parent',
                    'tab' => 'Wealth-On',
                    'span' => 'auto',
                    'type' => 'dropdown',
                    'options' => Member::getMemberIdOptions(),
                ],
                'referral_id' => [
                    'label' => 'Parent',
                    'tab' => 'Wealth-On',
                    'span' => 'auto',
                    'type' => 'dropdown',
                    'options' => Member::getMemberIdOptions(),
                ],
                'store_enabled' => [
                    'label' => 'Activate Online Store',
                    'tab' => 'Wealth-On',
                    'span' => 'auto',
                    'type' => 'dropdown',
                    'options' => ["0" => "No", "1" => "Yes"],
                ],
                'is_director' => [
                    'label' => 'Company Director',
                    'tab' => 'Wealth-On',
                    'span' => 'auto',
                    'type' => 'dropdown',
                    'options' => ["0" => "No", "1" => "Yes"],
                ],
            ]);
        });
        /*
          UsersController::extendFormFields(function($form, $model, $context) {
          if (!$model instanceof User) {
          return;
          }
          $form->addTabFields([
          'package' => [
          'label'   => 'Package',
          'tab'     => 'Wealth On',
          'type'    => 'dropdown',
          'options' => [
          'unknown' =>'Unknown',
          'female'  => 'Female',
          'male'    => 'Male'
          ],
          'span'    => 'auto'
          ],
          ]);
          });
         * 
         */
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {

        return [
            '\Wealthon\System\Components\Packages' => 'packages',
            '\Wealthon\System\Components\App' => 'app',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions() {
        return [
            'wealthon.system.access_packages' => ['tab' => 'Wealth-On', 'label' => 'Manage Packages'],
            'wealthon.system.access_commission_plan' => ['tab' => 'Wealth-On', 'label' => 'Manage Commission Plans'],
            'wealthon.system.access_generation' => ['tab' => 'Wealth-On', 'label' => 'Manage Generations']
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation() {
        #return []; // Remove this line to activate

        return [
            'system' => [
                'label' => 'Wealth-On',
                'url' => Backend::url('wealthon/system/package'),
                'icon' => 'icon-briefcase',
                'permissions' => ['wealthon.system.*'],
                'order' => 500,
                'sideMenu' => [
                    'package' => [
                        'label' => 'Packages',
                        'icon' => 'icon-shopping-bag',
                        'url' => Backend::url('wealthon/system/package'),
                        'permissions' => ['wealthon.system.*']
                    ],
                    'commission_plan' => [
                        'label' => 'Plans',
                        'icon' => 'icon-percent',
                        'url' => Backend::url('wealthon/system/commissionplan'),
                        'permissions' => ['wealthon.system.*']
                    ],
                    'generation' => [
                        'label' => 'Generations',
                        'icon' => 'icon-sitemap',
                        'url' => Backend::url('wealthon/system/generation'),
                        'permissions' => ['wealthon.system.*']
                    ],
                    'store_type' => [
                        'label' => 'Store Types',
                        'icon' => 'icon-cart-plus',
                        'url' => Backend::url('wealthon/system/storetype'),
                        'permissions' => ['wealthon.system.*']
                    ],
                    'commission_type' => [
                        'label' => 'Commission Types',
                        'icon' => 'icon-briefcase',
                        'url' => Backend::url('wealthon/system/commissiontype'),
                        'permissions' => ['wealthon.system.*']
                    ],
                ]
            ]
        ];
    }

    public function registerSettings() {
        return [
            'settings' => [
                'label' => 'Settings & Configuration',
                'description' => 'System settings',
                'category' => 'Wealth-On',
                'icon' => 'icon-cog',
                'class' => 'Wealthon\System\Models\Settings',
                'permissions' => ['Access Settings'],
                'order' => 500
            ]
        ];
    }

}
