<?php

namespace JMinayaT\Menus\Tests;

use JMinayaT\Menus\MenusServiceProvider;
use JMinayaT\Menus\Facades\Menu as MenuFacade;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return lasselehtinen\MyPackage\MenusServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [MenusServiceProvider::class];
    }

    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Menu' => MenuFacade::class,
        ];
    }

     /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('menus', [
            'aspect' => [
                'MtsysAdmin'  => 'JMinayaT\Menus\Aspects\MtsysAdmin\SidebarMenuAspect',
            ],
            'default_aspect' => 'MtsysAdmin',
            'ordered'   =>    true,
            'orderBy'   =>    'title',
        ]);
    }
}