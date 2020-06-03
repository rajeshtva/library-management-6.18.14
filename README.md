<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>



## About This Laravel Project. 

This project is designed for library management system and it describes how to add a user, and an admin. give users permissions and roles. how to create books depending on permission of the user. Also, when it gives facility to subscribe books which is charged weekly. this also gives admin the ability to change book's price on weekly basis. 


### To run the cron job on the server during deployment
    php artisan schedule:run

This will automatically schedule calculating the weekly price for every user and every book.

## How to set up this project
* first git clone this project. 
    git@github.com:je-rajesh/library-management-6.18.14.git

* run `composer install` command
    composer install 
this will install all the required packages to the project.

* run `npm install` command
    npm install 
this will install all the node dependencies in the project.

* copy the .env.example to the .env by running 
    cp .env.example .env
add all needed configurations to the .env file. this file keeps all the laravel configurations.

* install authentication package of laravel 6
 
    composer require laravel/ui --dev
    php artisan ui vue --auth

* populate the database by 

    php artisan db:seed
