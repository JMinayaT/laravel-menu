<?php
namespace JMinayaT\Menus\Aspects\MtsysAdmin;

use JMinayaT\Menus\Aspects\Aspect;

class SidebarMenuAspect extends Aspect
{

    /**
     * Get Open container tag.
     *
     * @return string
     */
    public function getOpenContainerTag(){
        return '<ul class="list-unstyled components">'. PHP_EOL;
    }

    /**
     * Get close container tag.
     *
     * @return string
     */
    public function getCloseContainerTag()
    {
        return '</ul>';
    }

    /**
     * Get link tag.
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    public function getLinkTag($item)
    {
        return '<li' . $this->getActive($item) . '><a href="' .$item->getUrl() . '">' . $item->getIcon() .  $item->title . '</a></li>' . PHP_EOL;
    }

    /**
     * Get dropdown container.
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    public function getDropdownContainer($item)
    {
        return '<li class="nav-item-collapse">
                    <a href="#'.$item->title.'Submenu" data-toggle="collapse" aria-expanded="false">'. $item->getIcon() .  $item->title .'</a>
                        <ul class="collapse list-unstyled" id="'.$item->title.'Submenu">
                            '. $this->getChildMenuItems($item) .'
                        </ul>
                </li>'
        . PHP_EOL;
    }

    /**
     * Get active tag class.
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    protected function getActive($item)
    {   if($item->hasActive()) {
            return ' class="active"';
        }
        return '';
    }

}