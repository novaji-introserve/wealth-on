<?php

namespace Wealthon\Store;

use Backend;
use System\Classes\PluginBase;
use Feegleweb\OctoshopLite\Controllers\Products as ProductController;
use Feegleweb\OctoshopLite\Models\Product;
use Wealthon\System\Models\Member;

/**
 * store Plugin Information File
 */
class Plugin extends PluginBase {

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name' => 'Wealth-On Store',
            'description' => 'Online Store for Wealth-On',
            'author' => 'Jonathan Ogbimi',
            'icon' => 'icon-shopping-basket'
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
        ProductController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof Product) {
                return;
            }
            $form->addTabFields([
                'owner_id' => [
                    'label' => 'Product Owner',
                    'tab' => 'Owner',
                    'span' => 'both',
                    'type' => 'dropdown',
                    'options' => Member::getMemberIdOptions(),
                ],
            ]);
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {
        return []; // Remove this line to activate

        return [
            'Wealthon\Store\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions() {
        return []; // Remove this line to activate

        return [
            'wealthon.store.some_permission' => [
                'tab' => 'store',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation() {
        return []; // Remove this line to activate

        return [
            'store' => [
                'label' => 'store',
                'url' => Backend::url('wealthon/store/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['wealthon.store.*'],
                'order' => 500,
            ],
        ];
    }

}
