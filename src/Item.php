<?php
namespace JMinayaT\Menus;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Request;
use Closure;

class Item implements Arrayable
{
    /**
     * Item properties.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Item chields.
     *
     * @var array
     */
    protected $childs = [];
    /**
     * Item fillable attributes.
     *
     * @var array
     */
    protected $fillable = array(
        'url',
        'route',
        'title',
        'name',
        'icon',
        'parent',
        'attributes',
        'active',
        'order',
    );

    /**
     * Construct method.
     *
     * @param array $properties
     */
    public function __construct($properties = array())
    {
        $properties['order'] = null;
        $this->properties = $properties;
        $this->fill($properties);
    }

    /**
     * Get the instance as an array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getProperties();
    }

    /**
     * set attribute icon in item properties
     *
     * @param array $properties
     * @return array
     */
    protected static function setIconAttribute(array $properties)
    {
        $icon = array_get($properties, 'attributes.icon');
        if (!is_null($icon)) {
            $properties['icon'] = $icon;
            array_forget($properties, 'attributes.icon');
            return $properties;
        }
        return $properties;
    }

    /**
     * Create new item static instance.
     *
     * @param array $properties
     * @return object
     */
    public static function make(array $properties)
    {
        $properties = self::setIconAttribute($properties);
        return new static($properties);
    }

    /**
     * Create item child.
     *
     * @param array $properties
     * @return object
     */
    public function child(array $properties)
    {
        $child = static::make($properties);
        $this->childs[] = $child;
        return $child;
    }

    /**
     * Set order number of the item.
     *
     * @param int $order
     */
    public function order($order)
    {
        $this->order = $order;
    }

    /**
     * Create menu link.
     *
     * @param string $url
     * @param string $title
     * @param array $attributes
     * @return object
     */
    public function link($url, $title, $attributes = array())
    {
        return $this->child(compact('url','title','attributes'));
    }

    /**
     * Create menu route.
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
        return $this->child(compact('route','title','attributes'));
    }

    /**
     *Create menu dropdown.
     *
     * @param string $title
     * @param array $attributes
     * @param Closure $callback
     * @return object
     */
    public function dropdown($title, $attributes = array(), Closure $callback)
    {
        $properties = compact('title', 'attributes');
        $child = static::make($properties);
        call_user_func($callback, $child);
        $this->childs[] = $child;
        return $child;
    }

    /**
     * Has dropdown.
     *
     * @return bool
     */
    public function hasDropdown()
    {
        return !empty($this->childs);
    }

    /**
     * Get all chields.
     *
     * @return array
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Get item properties.
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * fill attributes.
     *
     * @param array $attributes
     */
    public function fill($attributes)
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Get item url.
     *
     * @return string
     */
    public function getUrl()
    {
        if (isset($this->route)) {
            return $this->getRoute($this->route);
        }
        return url($this->url);
    }

    /**
     * Get item route.
     *
     * @param mixed $route
     * @return string
     */
    public function getRoute($route)
    {
        if( is_array($route) ){
            return route($route[0],$route[1]);
        }
        return route($route);
    }

    /**
     * Has active item.
     *
     * @return bool
     */
    public function hasActive()
    {
        return Request::is($this->getUrlRequest());
    }

    /**
     * Get request from url.
     *
     * @return string
     */
    public function getUrlRequest()
    {
        $urlRequest = ltrim(str_replace(url('/'), '', $this->getUrl()), '/');
        if($urlRequest ==""){
            $urlRequest ="/";
        }
        return $urlRequest;
    }

    /**
     * Get item icon tag.
     *
     * @return string
     */
    public function getIcon()
    {
        if(isset($this->icon)) {
            if ($this->icon !== null && $this->icon !== '') {
                return '<i class="' . $this->icon . '"></i> ';
            }
        }
    }

    /**
     * edit child item
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function edit($key, $value)
    {
        return collect($this->childs)->filter(function ($child) use ($key, $value) {
            return $child->{$key} == $value;
        })->first();
    }

}