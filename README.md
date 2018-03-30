# Modules
[![Laravel](https://img.shields.io/badge/laravel-5-orange.svg)](http://laravel.com)
[![Release](https://poser.pugx.org/artem-schander/l5-modular/v/stable)](https://github.com/trieunb/Modules)
[![Source](https://img.shields.io/badge/source-Artem_Schander-blue.svg)](https://github.com/trieunb/Modules)
[![Contributor](https://img.shields.io/badge/contributor-Farhan Wazir-blue.svg)](https://github.com/trieunb)
[![License](https://poser.pugx.org/artem-schander/l5-modular/license)](https://github.com/trieunb/Modules)

This package gives you the ability to use Laravel 5 with module system.
You can simply drop or generate modules with their own controllers, models, views, translations and a routes file into the `app/Modules` folder and go on working with them.

Thanks to zyhn for the ["Modular Structure in Laravel 5" tutorial](https://github.com/trieunb/Modules). Well explained and helped a lot.

## Documentation

* [Installation](#installation)
* [Getting started](#getting-started)
* [Usage](#usage)


<a name="installation"></a>
## Installation

The best way to install this package is through your terminal via Composer.

Run the following command from your projects root
```
composer require trieunb/modules
```
Once this operation is complete, simply add the service provider to your project's `config/app.php` and you're done.

#### Service Provider
```
Trieunb\Modules\ModuleServiceProvider::class,
```

<a name="getting-started"></a>
## Getting started

The built in Artisan command `php artisan make:module name [--no-migration] [--no-translation]` generates a ready to use module in the `app/Modules` folder and a migration if necessary.

Since version 1.3.0 you can generate modules named with more than one word, like `foo-bar`.

This is how the generated module would look like:
```
laravel-project/
    app/
    └── Modules/
        └── Demo/
            ├── Controllers/
            │   └── DemoController.php
            ├── Models/
            │   └── Demo.php
            ├── Views/
            │   └── index.blade.php
            └── routes.php
                
```

<a name="usage"></a>
## Usage

The generated `RESTful Resource Controller` and the corresponding `routes.php` make it easy to dive in. In my example you would see the output from the `Modules/Demo/Views/index.blade.php` when you open `laravel-project:8000/Demo` in your browser.

## License

L5Modular is licensed under the terms of the [MIT License](http://opensource.org/licenses/MIT)
(See LICENSE file for details).

---
