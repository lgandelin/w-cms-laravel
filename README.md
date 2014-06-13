##W CMS Laravel package


W CMS is a web application created to provide a complete content management system, easy to use and to help people writing their content.

**This repository is the Laravel package created for the [W CMS core](https://github.com/lgandelin/cms-core).**


##Features

- SEO implementation
- Multilingual
- Page architecture divided in Areas and Blocks, with dynamic reorganization (size, drag and drop)
- Page templates
- Mutliple types of Blocks : HMTL, Menus, Articles, Galleries, Custom ...
- User management for the back-office, with roles and permissions


##Requirements

- Laravel 4
- PHP 5.4


##Installation

1. Install Laravel :

        composer create-project laravel/laravel your-application --prefer-dist

        
2. Add the package to your composer.json file :

        "require": {
            "webaccess/w-cms-laravel": "dev-master"
        }

    and update your composer dependencies :

        composer update


3. Add the CMS service provider in your app.file to enable the package :
    
        'providers' => array(
                [...],
                'Webaccess\WCMSLaravel\WCMSLaravelServiceProvider',
        ),

 
4. Configure your app.php and your environment

5. Execute the package migration to update your database :

        php artisan migrate --package=webaccess/w-cms-laravel

6. Publish the package assets :

        php artisan asset:publish

7.  Execute the package seeds :

        php artisan db:seed --class=WCMSSeeder

##Usage

- Front page : http://your-application.dev/ (your web root)
- Back-office interface : http://your-application.dev/admin
    - **Login** : jdoe
    - **Password** : 111aaa


##Roadmap
Please go the the [CMS core page](https://github.com/lgandelin/cms-core/blob/master/ROADMAP.md).


##License
The CMS Laravel Package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)