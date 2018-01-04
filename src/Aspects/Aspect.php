<?php

namespace  JMinayaT\Menus\Aspects;

use JMinayaT\Menus\Item;

abstract class Aspect implements AspectInterface
{

    /**
     * Get Open container tag.
     *
     * @return string
     */
    public function getOpenContainerTag(){}

    /**
     * Get close container tag.
     *
     * @return string
     */
    public function getCloseContainerTag(){}
    
    /**
     * Get link tag.
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    public function getLinkTag($item){}

    /**
     * Get dropdown container.
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    public function getDropdownContainer($item){}

    /**
     * Get child menu items
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    public function getChildMenuItems(Item $item)
    {
        $menu='';
        foreach ($item->getChilds() as $child) {
            if ($child->hasDropdown()) {
                $menu .= $this->getDropdownContainer($child);
            }
            else{
            $menu .= $this->getLinktag($child);
            }
        }
        $menu .= $this->getCloseContainerTag();
        return $menu;
    }

}