##UVEL

“Uvel” (e-commerce project based on [Laravel](https://laravel.com/)) offers to his clients large number of gold and silver jewelries on stock and can make unique models by picture.

## Installation

**To create a project from this repository:**

```
git clone git@gitlab.com:rubber-duck/uvel.git
cd uvel/
git checkout develop
Copy .env.example to .env (set database, username and password).
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```