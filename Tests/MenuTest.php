<?php
namespace JMinayaT\Menus\Tests;

use Menu;
use JMinayaT\Menus\Builder;

class MenuTest extends TestCase
{
    
    public function test_create_empty_menu()
    {
        Menu::create('test',function($menu){
        });
        $expected = '<ul class="list-unstyled components"></ul>';
        $this->assertEquals($expected,Menu::get('test'));
    }

    public function test_get_menu_intance_of_builder()
    {
        Menu::create('test',function($menu){
        });
        $this->assertInstanceOf(Builder::class, Menu::instance('test'));
    }
}