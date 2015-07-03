##W CMS - Laravel package


W CMS is a web application created to provide a complete and easy way to manage users web pages.

**This repository is the Laravel package created for the [W CMS - Core package](https://github.com/lgandelin/w-cms-core).**


##Features

- SEO implementation
- Multilingual
- Page architecture divided in Areas and Blocks, with dynamic reorganization (size, drag and drop)
- Image management (crop, compression, automatic sizes...)
- Mutliple types of Blocks (HMTL, Images, Menus, Files, Articles, Galleries, Custom ...)
-  Users permissions management


##Requirements

- PHP 5.5.9
- MySQL database


##Installation

###Laravel installation

1. Create a new Laravel application :

        composer create-project laravel/laravel --prefer-dist your-app

2. Setup the database configuration in your .env file

3. Set the application namespace :

        cd your-app && php artisan app:name YourApp

4. Remove the base routes file content (in app/Http/routes.php)


###W CMS Laravel package installation

1. In your composer.json file, add the following line in the require section :

        "webaccess/w-cms-laravel": "dev-master"

    then update composer dependencies with :

        composer update

2. Add the W CMS Laravel service provider in your config/app.php file to enable the package :
    
        'providers' => [
                [...],
                Webaccess\WCMSLaravel\WCMSLaravelServiceProvider::class,
        ],

 
3. Run the following commands. Be sure to replace your "theme name" with our own.

        php artisan vendor:publish &&
        composer dump-autoload &&
        php artisan migrate &&
        php artisan db:seed --class=DefaultLangsSeeder &&
        php artisan db:seed --class=DefaultBlockTypesSeeder &&
        php artisan db:seed --class=SamplePageDataSeeder &&
        php artisan users:create admin &&
        php artisan theme:create your-theme-name

    The commands will publish all the necessary files in your application, migrate the database and populate it with sample data. Finally, it will create the "admin" user, generate a password for you, and create a new theme.

4. In your config/auth.php file, set the "driver" field to "database", and the "table" field to "w_cms_users"


##Usage

- Front page : http://your-app.dev/ (your web root)
- Admin interface : http://your-app.dev/admin (log in with the info provided in 3.)


##License
W CMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)