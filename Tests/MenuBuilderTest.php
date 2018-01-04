<?php
namespace JMinayaT\Menus\Tests;

use JMinayaT\Menus\Builder;
use JMinayaT\Menus\Item;
use JMinayaT\Menus\Aspects\Aspect;

class MenuBuilderTest extends TestCase
{
    
    public function test_get_aspect_intance_of_aspect()
    {
        $builder = new Builder('test');
        $this->assertInstanceOf(Aspect::class, $builder->getAspect());
    }

    public function test_make_menu_link_item()
    {
        $builder = new Builder('test');
        $this->assertInstanceOf(Item::class, $builder->link('testurl','testname'));
    }
    public function test_create_a_dropdown_menu_item()
    {
         $builder = new Builder('test');
         $builder->dropdown('testurl',function(Item $sub){
            $sub->link('test/1', 'test1');
            $sub->link('test/2', 'test2');
         });
         $items = $builder->getItems();
         $this->assertCount(1, $items);
         $this->assertCount(2, $items[0]->getChilds());
    }
    
    public function test_render_as_dropdown()
    {
        $builder = new Builder('test');
        $builder->dropdown('testurl',function(Item $sub){
            $sub->link('test/1', 'test1');
            $sub->link('test/2', 'test2');
        });
        foreach ($builder->getItems() as $item) {
            $this->assertTrue($item->hasDropdown());
        }
    }

    public function test_item_collection_sortBy_title()
    {
        $builder = new Builder('test');
        $builder->link('test/1', 'manuel');
        $builder->link('test/1', 'ana');
        $builder->link('test/1', 'delia');
        $builder->link('test/1', 'pedro');
        $builder->link('test/1', 'javier');
        $builder->link('test/1', 'jose');
        $builder->link('test/1', 'carlos');
        $items = [];
        foreach ($builder->sortByTitle() as $item) {
            $items[] = $item->title;
        }
        $this->assertEquals(['ana','carlos','delia','javier','jose','manuel','pedro'],$items);
    }

    public function test_item_collection_sortBy_order()
    {
        $builder = new Builder('test');
        $builder->link('test/1', 'manuel')->order(7);
        $builder->link('test/1', 'ana')->order(1);
        $builder->link('test/1', 'delia')->order(2);
        $builder->link('test/1', 'pedro')->order(6);
        $builder->link('test/1', 'javier')->order(3);
        $builder->link('test/1', 'jose')->order(5);
        $builder->link('test/1', 'carlos')->order(4);
        $items = [];
        foreach ($builder->sortByNumber() as $item) {
            $items[] = $item->title;
        }
        $this->assertEquals(['ana','delia','javier','carlos','jose','pedro','manuel'],$items);
    }

      public function test_item_collection_ordered()
    {
        $builder = new Builder('test');
        $builder->link('test/1', 'manuel')->order(6);
        $builder->link('test/1', 'ana')->order(1);
        $builder->link('test/1', 'delia')->order(3);
        $builder->link('test/1', 'pedro')->order(7);
        $builder->link('test/1', 'javier')->order(4);
        $builder->link('test/1', 'jose')->order(5);
        $builder->link('test/1', 'carlos')->order(2);
        $builder->setOrderBy('number');
        $items = [];
        foreach ($builder->getOrderedItems() as $item) {
            $items[] = $item->title;
        }
        $expected = ['ana','carlos','delia','javier','jose','manuel','pedro'];
        $this->assertEquals($expected,$items);



    }
    

}