<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project Management
    This project is a simple app providing project management for two types of users: admins and regular users. 

## Installation

    Commands:
        composer install
        npm install
        npm run dev
        php artisan migrate
        php artisan storage:link
        php artisan db:seed
    To run the project:
        php artisan serve
        npm run dev
## Laravel Nova

    Laravel Nova is used for the administration panel. To install the package you need to login with your Nova credentials.

## Generate an admin user

    Before creating users/admins it is necesarry to create the roles. Run the command db:seed !
        Make sure that the names are camelcase 'Admin' and 'User'
    To create an admin, use the command
        php artisan nova:user 
    in you terminal and follow the instructions prompted. After successful user creation, you can login as an administrator at 127.0.0.1:8000/nova.

## Generate a normal user
    To create a normal user, login as an administrator, go to the 'Users' panel in the navigation and click on the 'Create' button. This will generate an user with a normal role.
    To login as a normal user, go to 127.0.0.1:8000/login

## Logout
    To logout, click your username in the top right corner of the Nova Dashboard, then from the dropdown menu select 'Logout'

## Panels

    In the Nova dashboard users can see Resources based on their role, Admin or User. An Admin can view, edit or delete any of the four resources: Comments, Users, Tasks or Projects. An admin can also view metrics regarding tasks, projects and users on the dashboard and filter Tasks by Status and Users by Role.

    A regular user can only see comments or tasks assigned to their id. On the dashboard a regular user views a panel with user names.

## Issues

    If you have any issues in installing the project please send me an e-mail at ana.milea15@lgmail.com or contact me on LinkedIn.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
