#### Test-Shop POC built with Laravel, Vue.js, Tailwind.css and Inertia.js
You can seed an admin user to login to the backoffice `/admin/login` where you can manage your products.

You can add items to your cart list and manage your cart on the cart page `/cart/view`. Here you'll find an overview of all your current items in your shopping cart.
You can either add items to your cart from the homepage "latest products" section or from the products list page `/products`.

> As a guest user you can also add items your cart and these items are stored in a cookie that will persist after registering so you don't lose your cart. (need to fix some little bugs)

You can view the detail page of a product by accessing `/products/{slug}`. These slugs are created with the product title. (https://github.com/spatie/laravel-sluggable)
Or you can hover a product and click the little eye icon in the front end.
On the detail page you can see a list of the images and preview the full size, the title, the description, the price. I also added a category taxonomy.

You can browse a list of the products on the products page `/products`. And you can apply price range + category taxonomy filters to ease your search.

## Installation

Make sure you have environment setup properly. You will need `MySQL`, `PHP8.1`, `Node.js` and `composer.

## Install Laravel Website + API

### Clone repository
You can simply clone the project to your local storage with following command:
```
git clone https://github.com/moussa112/awesome-test-shop.git
```
### Setup env file
Copy .env.example into .env and configure database credentials

### Install backend
Navigate to the project's root directory using terminal and run:
```
composer install
```
### Setup encryption key (might not be needed)
```
php artisan key:generate
```
### Setup database
Run migration
```
php artisan migrate --seed
```
Seed database

You can find all seeders under database/seeders
```
php artisan db:seed AdminSeeder
```
### Start local server
```
php artisan serve
```
### Install front end
Navigate to the project's root directory using terminal and run:
```
npm install
```
### Start vite server for Laravel frontend
```
npm run dev
```
