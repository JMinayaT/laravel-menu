<?php
namespace JMinayaT\Menus;

use Closure;

class Builder
{

    /**
     * Menu.
     *
     * @var string
     */
    protected $menu;

    /**
     * All Items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Default aspect name class.
     *
     * @var string
     */
    protected $aspect;

    /**
     * Ordered item.
     *
     * @var boolean
     */
    protected $ordered;

    /**
     * Order by type: 'title' or 'number'
     *
     * @var string
     */
    protected $orderBy;

    /**
     * Construct method.
     *
     * @param string $menu
     */
    public function __construct($menu)
    {
        $this->menu = $menu;
        $this->setMenusConfig();
    }

    /**
     * Set menus config.
     *
     * @return void
     */
    public function setMenusConfig()
    {
        $this->ordered = config('menus.ordered');
        $this->orderBy = config('menus.orderBy');
        $this->aspect = config('menus.default_aspect');
    }

    /**
     * Render menu to html
     *
     * @return string
     */
    public function render()
    {
        $aspect = $this->getAspect();
        $menu = $aspect->getOpenContainerTag();
        foreach ($this->getOrderedItems() as $item) {
            if ($item->hasDropdown()) {
                $menu .= $aspect->getDropdownContainer($item);
            } 
            else{
                $menu .= $aspect->getLinktag($item);
            }
        }
        $menu .= $aspect->getCloseContainerTag();

        return $menu;
    }

    /**
     * Create new aspects instance.
     *
     * @return object
     */
    public function getAspect()
    {
        $aspect = config('menus.aspect');
        $obj = $aspect[$this->aspect];
        return new $obj();
    }
    /**
     * Get menu name.
     *
     * @return void
     */
    public function getName()
    {
        return $this->menu;
    }

    /**
     * Set aspact.
     *
     * @param string $aspect
     */
    public function setAspact($aspect)
    {
        $this->aspect = $aspect;
    }

    /**
     * Item to collection array.
     *
     * @return array
     */
    public function toCollection()
    {
        return collect($this->items);
    }

    /**
     * Order items by title.
     *
     * @return array
     */
    public function sortByTitle()
    {
        return $this->toCollection()->sortBy(function ($item) {
            return $item->title;
        })->all();
        
    }

    /**
     * Order items by num order.
     *
     * @return array
     */
    public function sortByNumber()
    {
        return $this->toCollection()->sortBy(function ($item) {
            return $item->order;
        })->all();
    }
    
    /**
     * Get ordered items
     *
     * @return array
     */
    public function getOrderedItems()
    {
        if($this->ordered){
            if($this->orderBy == 'title') {
                return $this->sortByTitle();
            } 
            elseif($this->orderBy == 'number') {
                return $this->sortByNumber();
            }
        }
        return $this->items;
    }

    /**
     * set Order by type: 'title' or 'number'.
     *
     * @param string $type
     */
    public function setOrderBy($type)
    {
        $this->orderBy = $type;
    }

    /**
     * Active ordered.
     *
     */
    public function activeOrder()
    {
        $this->ordered = true;
    }

    /**
     * Disable ordered.
     *
     */
    public function disableOrder()
    {
        $this->ordered = false;
    }

    /**
     * Create menu item link.
     *
     * @param string $url
     * @param string $title
     * @param array $attributes
     * @return object
     */
    public function link($url, $title, $attributes = array())
    {
        $item = Item::make(compact('url','title','attributes'));
        $this->items[] = $item;
        return $item;
    }
    
    /**
     * Create menu item route.
     *
     * @param string $route
     * @param string $title
     * @param array $parameters
     * @param array $attributes
     * @return object
     */
    public function route($route,$title, $parameters=[], $attributes=[])
    {
        if(! empty($parameters)) {
            $route = [$route, $parameters];
        }   
        $item = Item::make(compact('route','title','attributes'));
        $this->items[] = $item;
        return $item;
    }

    /**
     * Create menu item dropdown.
     *
     * @param mixed $title
     * @param array $attributes
     * @param Closure $callback
     * @return object
     */
    public function dropdown($title, $attributes = array(), Closure $callback)
    {
        $properties = compact('title', 'attributes');
        $item = Item::make($properties);
        call_user_func($callback, $item);
        $this->items[] = $item;
        return $item;
    }

    /**
     * Get all Items.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Edit item from menu
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function edit($key, $value)
    {
        return collect($this->items)->filter(function ($item) use ($key, $value) {
            return $item->{$key} == $value;
        })->first();
    }

}