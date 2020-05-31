<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>



## About Laravel

This project is designed for library management system and it describes how to add a user, and an admin. give users permissions and roles. how to create books depending on permission of the user. Also, when it gives facility to subscribe books which is charged weekly. this also gives admin the ability to change book's price on weekly basis. 


### To run the cron job on the server during deployment
    php artisan schedule:run

This will automatically schedule calculating the weekly price for every user and every book.