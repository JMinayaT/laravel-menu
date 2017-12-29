<?php
namespace JMinayaT\Menus;

use Closure;

class MenuService 
{
    protected $menus = [];
    public function create($name, Closure $resolver)
    {
        $builder = new Builder($name);
        $this->menus[$name] = $builder;      
    }

    public function get($name)
    {  
        return $this->has($name) ?  $this->menus[$name]->render() : null;
    }

    public function has($name)
    {
        return array_key_exists($name, $this->menus);
    }

    public function instance($name)
    {
        return $this->has($name) ? $this->menus[$name] : null;
    }
}