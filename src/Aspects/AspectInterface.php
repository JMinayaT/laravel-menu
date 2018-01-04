<?php

namespace  JMinayaT\Menus\Aspects;

use JMinayaT\Menus\Item;

interface AspectInterface
{

    /**
     * Get Open container tag.
     *
     * @return string
     */
    public function getOpenContainerTag();

    /**
     * Get close container tag.
     *
     * @return string
     */
    public function getCloseContainerTag();

    /**
     * Get dropdown container.
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    public function getDropdownContainer($item);

    /**
     * Get link tag.
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    public function getLinkTag($item);

    /**
     * Get child menu items
     *
     * @param JMinayaT\Menus\Item $item
     * @return string
     */
    public function getChildMenuItems(Item $item);

}