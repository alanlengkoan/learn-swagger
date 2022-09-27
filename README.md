# REST-API
	
## Required
* php 7.4
* laravel 8

## Install
* add env for your local config and database
  [env.example](https://github.com/platformsh-templates/laravel/blob/master/.env.example)
* run this command
```
~ composer install
~ php artisan db:create db_name
~ php artisan migrate:fresh --seed
~ php artisan serve
```
* acccess [http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation) to read and test API use Swagger UI.
  
## Unit test
* for testing /settings
```
~ vendor/bin/phpunit .\tests\Feature\SettingsTest.php
```
* for testing /employees
```
~ vendor/bin/phpunit .\tests\Feature\EmployeesTest.php
```
* for testing /overtimes
```
~ vendor/bin/phpunit .\tests\Feature\OvertimesTest.php
```
* for testing /overtime-pays/calculate
```
~ vendor/bin/phpunit .\tests\Feature\OvertimepayTest.php
```