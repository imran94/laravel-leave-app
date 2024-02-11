A web portal made in Laravel for the purpose of company employees to apply for leave and have it approved by their team lead or an admin. When a user applies for leave, it notifies his team lead and every admin in the company. The application tracks the number of leaves they have availed and how many they have left for the year, and it provides detailed views for the admins to look at regarding each employee.

## To run the program:

1. Import the database into your MySQL server through the provided sql file.
2. Point to the database in the .env file.
3. If you wish to test the email feature, set your email server credentials as well in the .env file.
4. Install dependencies via `composer install`
5. Start the application with `php artisan serve`. You need a PHP version of at least 8.0
