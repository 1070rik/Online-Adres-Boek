## Online adres boek
#### Eind project PHP, HTML/CSS, DBS

### How to install
1. Clone the repo
2. Install [Composer](https://getcomposer.org/doc/00-intro.md)
3. Run `composer install`
4. Run `cp .env.example .env`
5. Run `nano .env` and change all the database information
6. Save the file
7. Run `php artisan key:gemerate`
8. Run `php artisan serve`

### Errors?
___500  error___
---Make sure you have given the `storage` and `bootstrap/cache` folder r/w permission
