<?php
namespace JMinayaT\Menus\Tests;

use JMinayaT\Menus\MenuService;

class MenuTest extends TestCase
{
     /**
     * Check that the suma method returns correct result
     * @return void
     */
    public function testMenuSuma()
    {
        $this->assertSame(MenuService::suma(1, 8), 9);
        $this->assertSame(MenuService::suma(2, 8), 10);
    }
}