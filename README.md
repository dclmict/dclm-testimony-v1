<p align="center"><a href="https://dclm.org" target="_blank"><img src="https://dclmcloud.s3.amazonaws.com/img/logo.png" width="306.5" height="275.5"></a></p>

## DCLM Testimony

This is a laravel app to collect testimonies from our online community and global audience.

App url: [DCLM Testimony](https://testimony.dclm.org)

## How to Run
### Monolith architecture
- enter app director `cd app`
- create .env file `cp .env.example .env`
- add aws credentials to .env file
- add database credentials to .env file
- install dependencies `composer install`
- run `php artisan key:generate`
- run `php artisan migrate`
- run `php artisan db:seed`
- run `php artisan optimize:clear`

### Microservices architecture (Docker)
- run `make dev`
- run `make key`
- run `make migrate`
- run `make seed`
## Credit

App built and released by [DCLM Developers Community](https://developers.dclm.org).
