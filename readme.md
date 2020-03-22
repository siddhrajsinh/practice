
## Installation

Please check the official Laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.6/installation#installation)

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Install all the dependencies using composer

    composer install

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeder
    php artisan db::seed

IF it's not working then run below command
    php artisan db:seed --class=CreateAdminUserTableSeeder
    php artisan db:seed --class=CreateVisitorsTableSeeder

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
