<p align="center"><a href="https://dclm.org" target="_blank"><img src="https://dclmcloud.s3.amazonaws.com/img/logo.png" width="306.5" height="275.5"></a></p>

## DCLM Testimony

This is a laravel app to collect testimonies from our online community and global audience.

App url: [DCLM Testimony](https://testimony.dclm.org)

## How to Run
- add aws credentials to .env file
- add database infos (mysql)
- composer install
- composer require league/flysystem-aws-s3-v3 "~1.0" --update-with-all-dependencies
- php artisan migrate
- php artisan db:seed
- php artisan db:seed --class=RoleSeeder

## Credit

App built and released by [DCLM Developers Community](https://developers.dclm.org).
