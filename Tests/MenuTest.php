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
        $expected = '<ul class="list-unstyled components">
</ul>';
        $this->assertEquals($expected,Menu::get('test'));
    }

    public function test_get_menu_intance_of_builder()
    {
        Menu::create('test',function($menu){
        });
        $this->assertInstanceOf(Builder::class, Menu::instance('test'));
    }

    public function test_create_link_menu()
    {
        Menu::create('test',function($menu){
            $menu->link('/test','test',['icon'=>'fa-fa-icon']);
        });
        $expected = '<ul class="list-unstyled components">
<li><a href="http://localhost/test"><i class="fa-fa-icon"></i> test</a></li>
</ul>';
        $this->assertEquals($expected,Menu::get('test'));
    }

    
    public function test_create_dropdown_menu()
    {
        Menu::create('test',function($menu){
            $menu->dropdown('test', function($sub){
                $sub->link('/test','test',['icon'=>'fa-fa-icon']);
            });
        });
        $expected = '<ul class="list-unstyled components">
<li class="nav-item-collapse">
                    <a href="#testSubmenu" data-toggle="collapse" aria-expanded="false">test</a>
                        <ul class="collapse list-unstyled" id="testSubmenu">
                            <li><a href="http://localhost/test"><i class="fa-fa-icon"></i> test</a></li>
</ul>
                        </ul>
                </li>
</ul>';
        $this->assertEquals($expected,Menu::get('test'));
    }

    public function test_create_sub_dropdown_menu()
    {
        Menu::create('test',function($menu){
            $menu->dropdown('test', function($sub){
                $sub->link('/test','test',['icon'=>'fa-fa-icon']);
                $sub->dropdown('test', function($sub){
                    $sub->link('/tes2','test2',['icon'=>'fa-fa-icon']);
                });
            });
        });
        $expected = '<ul class="list-unstyled components">
<li class="nav-item-collapse">
                    <a href="#testSubmenu" data-toggle="collapse" aria-expanded="false">test</a>
                        <ul class="collapse list-unstyled" id="testSubmenu">
                            <li><a href="http://localhost/test"><i class="fa-fa-icon"></i> test</a></li>
<li class="nav-item-collapse">
                    <a href="#testSubmenu" data-toggle="collapse" aria-expanded="false">test</a>
                        <ul class="collapse list-unstyled" id="testSubmenu">
                            <li><a href="http://localhost/tes2"><i class="fa-fa-icon"></i> test2</a></li>
</ul>
                        </ul>
                </li>
</ul>
                        </ul>
                </li>
</ul>';
        $this->assertEquals($expected,Menu::get('test'));
    }

    public function test_edit_menu()
    {
        Menu::create('test',function($menu){
            $menu->link('/test','test',['icon'=>'fa-fa-icon']);
        });

        Menu::edit('test',function($menu){
            $menu->link('/test2','test2',['icon'=>'fa-fa-icon']);
        });
        $expected = '<ul class="list-unstyled components">
<li><a href="http://localhost/test"><i class="fa-fa-icon"></i> test</a></li>
<li><a href="http://localhost/test2"><i class="fa-fa-icon"></i> test2</a></li>
</ul>';
        $this->assertEquals($expected,Menu::get('test'));

    }

    public function test_edit_item_menu()
    {
        Menu::create('test',function($menu){
            $menu->link('test','test',['icon'=>'fa-fa-icon']);
        });

        Menu::edit('test',function($menu){
            $menuItem = $menu->edit('title', 'test');
            $menuItem->title = 'hola';
        });
        $expected = '<ul class="list-unstyled components">
<li><a href="http://localhost/test"><i class="fa-fa-icon"></i> hola</a></li>
</ul>';
        $this->assertEquals($expected,Menu::get('test'));

    }

    public function test_edit_dropdown_item_menu()
    {
        Menu::create('test',function($menu){
            $menu->dropdown('test', function($menu){
                    $menu->link('/test1','test1',['icon'=>'fa-fa-icon']);
                });
        });

        Menu::edit('test',function($menu){
            $menuItem = $menu->edit('title', 'test');
            $menuItem->link('/test2','testt2',['icon'=>'fa-fa-icon']);
        });
        $expected = '<ul class="list-unstyled components">
<li class="nav-item-collapse">
                    <a href="#testSubmenu" data-toggle="collapse" aria-expanded="false">test</a>
                        <ul class="collapse list-unstyled" id="testSubmenu">
                            <li><a href="http://localhost/test1"><i class="fa-fa-icon"></i> test1</a></li>
<li><a href="http://localhost/test2"><i class="fa-fa-icon"></i> testt2</a></li>
</ul>
                        </ul>
                </li>
</ul>';
        $this->assertEquals($expected,Menu::get('test'));

    }

    public function test_edit_sub_dropdown_item_menu()
    {
        Menu::create('test',function($menu){
            $menu->dropdown('test', function($menu){
                    $menu->link('test1','test1',['icon'=>'fa-fa-icon']);
                });
        });

        Menu::edit('test',function($menu){
            $menuItem = $menu->edit('title', 'test');
            $subMenuItem = $menuItem->edit('title', 'test1');
            $subMenuItem->title = 'test22';
        });
        $expected = '<ul class="list-unstyled components">
<li class="nav-item-collapse">
                    <a href="#testSubmenu" data-toggle="collapse" aria-expanded="false">test</a>
                        <ul class="collapse list-unstyled" id="testSubmenu">
                            <li><a href="http://localhost/test1"><i class="fa-fa-icon"></i> test22</a></li>
</ul>
                        </ul>
                </li>
</ul>';
        $this->assertEquals($expected,Menu::get('test'));

    }
}