<?php
namespace JMinayaT\Menus;

class Builder
{
    protected $menu;
    protected $aspect = 'MtsysAdmin\SidebarMenuAspect';

    public function __construct($menu)
    {
        $this->menu = $menu;
    }

    public function render()
    {
        $aspect = $this->getAspect();
        $menu = $aspect->getOpenContainerTag();
        $menu .= $aspect->getCloseContainerTag();

        return $menu;
    }

    public function getAspect()
    {
        $obj = 'JMinayaT\Menus\Aspects\\' . $this->aspect;
        return new $obj();
    }

}