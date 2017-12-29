<?php
namespace JMinayaT\Menus\Tests;

use JMinayaT\Menus\Builder;
use JMinayaT\Menus\Aspects\Aspect;

class MenuBuilderTest extends TestCase
{
    
    public function test_get_aspect_intance_of_aspect()
    {
        $builder = new Builder('test');
        $this->assertInstanceOf(Aspect::class, $builder->getAspect());
    }
}