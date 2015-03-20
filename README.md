# Crumbs [![Build Status](https://travis-ci.org/coreplex/crumbs.svg?branch=master)](https://travis-ci.org/coreplex/crumbs)
Framework agnostic breadcrumb container

Installation via composer
-------------------------

The package requires PHP 5.4+, includes a Laravel 5 Service Provider/Facade for quick integration, and abides the FIG standard PSR-4, allowing for a consistent codebase. All Coreplex packages follow these set standards. The repository is also fully unit tested through and continuously integrated through use of [Travis CI](https://travis-ci.org/coreplex/crumbs).

To install Crumbs via composer, simply add it to your composer.json file

```json
"require": {
    "coreplex/crumbs": "~1.0"
},
```

Then run `composer update` via the command line. To automatically add this into your composer json, you can simply run `composer require coreplex/crumbs`, and composer will handle this all for you

The Container
-------------

All breadcrumbs are held in a **Container** class. This allows you to prepare and render a set of breadcrumbs. A container has two dependencies. A `Contracts\Crumb` instance, and a `Contracts\Renderer` instance. We provide basic ones in the repository to be used

```php
$container = new Coreplex\Crumbs\Container(new Coreplex\Crumbs\Components\Crumb, new Coreplex\Crumbs\Renderers\Basic);
```

To add a few breadcrumbs to the container, you can either use the `append` method directly, like so

```php
$container->append('Homepage', '/home');
```

Or you can use a closure to group them into their own scope. To do this, just call the `prepare` method and use any of the container functions on the passed instance

```php
$container->prepare(function($crumbs)
{
    $crumbs->append('Homepage', '/home')
           ->append('Edit');
});
```

To add a breadcrumb to the start of the container rather than the end, use the alternative `prepend` method

```php
$container->prepend('The Website', '/');
```

Rendering The Breadcrumbs
-------------------------

The basic renderer provided will return a simple list-based navigation string. This can be invoked through the main container class by just calling the `render` method.

```php
echo $container->render();
```

The render method causes the last breadcrumb to be active by default. To disable this behaviour, pass false as the first parameter when calling render.

```php
echo $container->render(false);
```

The container can also be rendered by simply echoing out the class, as it will
be implicitly type-cast to a string.

```php
echo $container;
```

Retrieving The Breadcrumbs and the Crumb Component
--------------------------------------------------

If you are going to be handling breadcrumbs from the container, you will want to access the numerous properties on the class. To do this, you can use the fluent attribute methods

```php
$container->append('The Website', '//www.website.com');

foreach ($container->crumbs() as $crumb) {
    var_dump($crumb->label()); // returns 'The Website'
    var_dump($crumb->url()); // returns '//www.website.com'
    var_dump($crumb->current()); // returns true
}
```

There are also respective setters and isSetters for each of the attributes on the class

```php
// Append an empty breadcrumb to the container
$container->append();

foreach ($container->crumbs() as $crumb) {
    var_dump($crumb->label()); // returns null

    if ( ! $crumb->hasLabel()) {
        $crumb->setLabel('The Website')
    }

    var_dump($crumb->url()); // returns null

    if ( ! $crumb->hasUrl()) {
        $crumb->setUrl('//www.website.com')
    }

    var_dump($crumb->current()); // returns true

    if ( ! $crumb->current()) {
        $crumb->setCurrent();
    }

    $crumb->setNotCurrent();

    var_dump($crumb->current()); // returns false
}
```

Laravel 5 Support
-------------------------
Crumbs has support for Laravel 5 out of the box. Once installed via composer, simply add the service provider to your app.php file

```php
'providers' => [

    'Coreplex\Crumbs\CrumbsServiceProvider',

]
```

And also publish the config via command line, using the `php artisan vendor:publish` function. This allows the config to be published to the correct directory

Once these steps have been taken, Crumbs can be dependency injected into any controller constructs like so

```php
/**
 * Make a new controller instance
 *
 * @param \Coreplex\Crumbs\Contracts\Container $breadcrumbs
 * @return void
 */
public function __construct(\Coreplex\Crumbs\Contracts\Container $breadcrumbs)
{
    $this->breadcrumbs = $breadcrumbs;
}
```

Which will then allow access to the breadcrumbs container via the breadcrumbs class property on the controller

A facade is also provided to those who would opt using this over dependency injection. Simply add it to the aliases array in app.php

```php
'aliases' => [

    'Crumbs' => 'Coreplex\Crumbs\Facades\Crumbs',

],
```

Which would then allow you to do things like this in your controllers

```php
use Crumbs;

class DashboardController extends Controller {

    public function index()
    {
        Crumbs::prepare(function($crumbs)
        {
            $crumbs->append('Dashboard Home', route('dashboard.index'));
        });

        return view('dashboard.index')->with('breadcrumbs', Crumbs::render());
    }

}
```

Planned Features
----------------

- Laravel 4 Integration