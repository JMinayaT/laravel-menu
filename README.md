# JMinayaT Laravel - Menu
`jminayat/modules-laravel` is a package for the administration of menus in laravel. compatible with Laravel version 5.5.

* [Installation](#installation)
* [Creating a menu](#creating-menu)
* [Rendering menu](#rendering-menu)
* [Edit menu](#edit-menu)
* [Configuration](#configuration)

## Installation
Install the package through the composer.
``` bash
composer require jminayat/laravel-menu
```
Next, publish the package configuration file by running:
``` bash
php artisan vendor:publish --provider="JMinayaT\Menus\MenusServiceProvider"
```

## Creating a menu
For the creation of a menu, call the creation method from Menu facade. The first parameter is the name of the menu and the second parameter is the callback to define the menu items.

```php
Menu::create('test',function($menu){
    $menu->link('home/1','Home',['icon'=>'icon-home']);
});
```
### Make Multiple Menus
If you want to create multiple menus
```php
Menu::create('test1',function($menu){
    $menu->link('home/1','Home',['icon'=>'icon-home']);
});

Menu::create('test2',function($menu){
    $menu->link('user','user');
});
```
### Menu items

### Menu Link
To create a link menu item use `$menu->link()`
```php
Menu::create('test',function($menu){
    //           'url'   'title'     'attributes'
    $menu->link('home/1','Home',['icon'=>'icon-home']);
});
```
### Menu Route
If you have a rute element defined with your name, use `$menu->route()`
```php
Menu::create('test',function($menu){
    //           'name rute'  'title'  'route parameters'    'attributes'
    $menu->route('cars.show', 'Cars', ['name'=>'toyota'], ['icon'=>'icon-car']);
});
```
### Menu Dropdown
to create a dropdown menu item use `$menu->dropdown()`
```php
Menu::create('test',function($menu){
    //             'title'    'attributes'          'callback '
    $menu->dropdown('test',['icon'=>'icon-test'], function($item){
            $item->link('/test','test1',['icon'=>'fa-fa-icon']);
            $item->link('/test','test2',['icon'=>'fa-fa-icon']);
            $item->link('/test','test3');
    });
});
```
### Menu Dropdown Multi Level
To create a drop-down menu within another drop-down menu use  `$item->dropdown()`

```php
Menu::create('test',function($menu){
    //             'title'    'attributes'          'callback '
    $menu->dropdown('test',['icon'=>'icon-test'], function($item){
            $item->link('/test','test1');
            
            $item->dropdown('test',['icon'=>'icon-test'], function($item){
                $item->link('/test','test2');
            });
    });
});
```
### Order Menu Items
You can sort the menu items in two ways, by the order number or alphabetically.

By default in the configuration file the ordering is deactivated, you can activate it directly in the configuration file or use the method `$menu->activeOrder()`.
```php
Menu::create('test',function($menu){
    $menu->activeOrder();
});
```

To set the value of the order call the method `->order()`.
```php
Menu::create('test',function($menu){
    $menu->activeOrder(); //active order
    $menu->link('home/1','Home',['icon'=>'icon-home'])->order(1);
    $menu->link('contact','Contact',['icon'=>'icon-contact'])->order(3);
    $menu->link('pages','Pages',)->order(2);
});
```
To order alphabetically use the method `$menu->setOrderBy($type)`.
```php
Menu::create('test',function($menu){
    $menu->activeOrder();// active order
    $menu->setOrderBy('title'); // 'title' or 'number'
});
```

By default, the orden function is disabled. You can enable the order function in your configuration file.

```php
return [
	'ordered' => true
];
```

And the type of order, by default is order by number.

```php
return [
	'orderBy' => 'title'
];
```

## Rendering menu
To render the menu you can use `show` or `get` method.
```php
Menu::get('test');

Menu::show('test');
```
## Edit menu
To edit a menu already created use the `edit` method of the facade Menu.
```php
Menu::edit('test',function($menu){
    $menu->link('home/1','Home',['icon'=>'icon-home']); // add link item
});
```

To edit an item in a menu.
```php
Menu::edit('test',function($menu){
    //            'search parameter'   'name'
    $menuItem = $menu->edit('title', 'test');
    $menuItem->title = 'hola';
});
```

To edit elements of a dropdown.
```php
Menu::edit('test',function($menu){
    //            'search parameter'   'name'
    $menuItem = $menu->edit('title', 'test'); //dropdown item
    $menuItem->link('/test2','testt2',['icon'=>'fa-fa-icon']); //add dropdown item
    //                   'search parameter'   'name'
    $subMenuItem = $menuItem->edit('title', 'test1'); //edit dorpdown item
    $subMenuItem->title = 'test3';
});
```

## Configuration
to publish the package configuration use the following command

``` bash
php artisan vendor:publish --provider="JMinayaT\Menus\MenusServiceProvider"
```

The content of the configuration file is as follows:

``` php
return [

    'aspect' => [
        
      'MtsysAdmin'  => 'JMinayaT\Menus\Aspects\MtsysAdmin\SidebarMenuAspect',
    ],

    'default_aspect' => 'MtsysAdmin',

    'ordered'   =>    false,

    'orderBy'   =>    'number',

];
```
### aspect
These are available ready to use menu aspects.

### default_aspect
set the default aspect.

### ordered
Enable or disable menu item ordering for all menus.

### orderBy
Set the default order type in alphabet or number.


## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
