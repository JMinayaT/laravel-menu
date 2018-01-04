<?php
namespace JMinayaT\Menus;

use Closure;

class MenuService 
{
    /**
     * All menus.
     *
     * @var array
     */
    protected $menus = [];

    /**
     * Create a new menu.
     *
     * @param string $name
     * @param Closure $closure
     * @return object
     */
    public function create($name, Closure $closure)
    {
        $builder = new Builder($name);
        $this->menus[$name] = $builder;
        return $closure($builder);
    }

    /**
     * Edit menu.
     *
     * @param string $name
     * @param Closure $callback
     * @return void
     */
    public function edit($name, Closure $callback)
    {
        $menu = collect($this->menus)->filter(function ($menu) use ($name) {
            return $menu->getName() == $name;
        })->first();
        $callback($menu);
    }

    /**
     * Get and render a menu.
     *
     * @param string $name
     * @return void
     */
    public function get($name)
    {  
        return $this->has($name) ?  $this->menus[$name]->render() : null;
    }

    /**
     * Show menu.
     *
     * @param string $name
     * @return void
     */
    public function show($name)
    {
        return $this-get($name);
    }

    /**
     * Has menu.
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->menus);
    }

    /**
     * Get a menu instance.
     *
     * @param string $name
     * @return object
     */
    public function instance($name)
    {
        return $this->has($name) ? $this->menus[$name] : null;
    }
}