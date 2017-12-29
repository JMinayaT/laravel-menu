<?php
namespace JMinayaT\Menus\Aspects\MtsysAdmin;

use JMinayaT\Menus\Aspects\Aspect;

class SidebarMenuAspect extends Aspect
{
    public function getOpenContainerTag(){
        return '<ul class="list-unstyled components">';
    }
    public function getCloseContainerTag()
    {
        return '</ul>';
    }
}