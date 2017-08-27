<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>


## Task API w/MongoDB

### Installation

- Check your system meets the requirements for Laravel 5.4 (check here for [details](https://laravel.com/docs/5.4)).
- Unzip or clone from Github repo and run `composer install` to download all project components,
don't forget to set write permissions for `storage` and `bootstrap\cache` folders.
- Configure `.env` file with database access credentials.
- (Optional) For testing purposes, you may want to fill your DB with dummy data, open a terminal window and navigate
to your project folder, and run `php artisan db:seed` to create 50 tasks.

## Using the API

### HTTP Verbs
This project works as a demo for a To-Do list app, with basic CRUD and filter functionality.

| HTTP METHOD | POST            | GET       | PUT         | DELETE |
| ----------- | --------------- | --------- | ----------- | ------ |
| CRUD OP     | CREATE          | READ      | UPDATE     | DELETE |
| /tasks       | Create new task | List all tasks | Not implemented | Not implemented |
| /tasks/1234  | Error           | Show 'Buy milk'   | If exists, update 'Buy milk'; If not, error | Delete 'Buy milk' |


### Filters
You can filter the tasks using the following endpoint and format: 
``` /tasks/filter?completed=1&due_date=2016-12-12&created_at=2014-03-09&updated_at=2015-10-11```

All parameter are optional and you can choose to use them or not

## Tests

You may test your installation running included tests.  Open a terminal window and navigate to you project folder.
Type:
``` .\vendor\bin\phpunit```
Green means go!