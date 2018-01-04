<?php
namespace JMinayaT\Menus\Tests;

use JMinayaT\Menus\Item;

class MenuItemTest extends TestCase
{
    
    public function test_make_an_empty_menu_item()
    {
        $menuItem = Item::make([]);
        $this->assertInstanceOf(Item::class, $menuItem);
    }

    public function test_get_properties_on_menu_item()
    {
        $properties = [
            'url' => 'my.url',
            'route' => 'my.route',
            'title' => 'My Menu item',
            'name' => 'my-menu-item',
            'icon' => 'fa fa-user',
            'parent' => 1,
            'attributes' => [],
            'active' => false,
            'order' => null,
        ];
        $menuItem = Item::make($properties);
        $this->assertEquals($properties, $menuItem->getProperties());
    }
    
    public function test_fill_a_menu_item_with_allowed_properties()
    {
        $properties = [
            'url' => 'my.url',
            'route' => 'my.route',
            'title' => 'My Menu item',
            'name' => 'my-menu-item',
            'icon' => 'fa fa-user',
            'parent' => 1,
            'attributes' => [],
            'active' => false,
            'order' => null,
        ];
        $menuItem = Item::make($properties);
        $this->assertEquals('my.url', $menuItem->url);
        $this->assertEquals('my.route', $menuItem->route);
        $this->assertEquals('My Menu item', $menuItem->title);
        $this->assertEquals('my-menu-item', $menuItem->name);
        $this->assertEquals('fa fa-user', $menuItem->icon);
        $this->assertSame(1, $menuItem->parent);
        $this->assertSame([], $menuItem->attributes);
        $this->assertFalse($menuItem->active);
        $this->assertSame(null, $menuItem->order);
    }

    public function test_get_item_attributes_to_properties()
    {
        $item = Item::make(['url'=>'/','title'=>'test','attributes' => ['icon'=>'fa fa_user']]);
        $this->assertEquals(['url'=>'/','title'=>'test','icon'=>'fa fa_user','attributes' => [],'order'=>null], $item->getProperties());
    }

    public function test_get_item_route_attributes_to_properties()
    {
        $item = Item::make(['url'=>'/','title'=>'test','attributes' => ['icon'=>'fa fa_user']]);
        $this->assertEquals(['url'=>'/','title'=>'test','icon'=>'fa fa_user','attributes' => [],'order'=>null], $item->getProperties());
    }

    public function test_add_a_child_menu_item()
    {
        $item = Item::make(['title' => 'Parent']);
        $item->child(['title' => 'Child 1']);
        $item->child(['title' => 'Child 2']);
        $this->assertCount(2, $item->getChilds());
    }

    public function test_item_as_dropdown()
    {
        $item = Item::make(['title' => 'Parent']);
        $item->child(['title' => 'Child 1']);
        $item->child(['title' => 'Child 2']);
        $this->assertTrue($item->hasDropdown());
    }
}