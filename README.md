<p align="center"><a href="https://dclm.org" target="_blank"><img src="https://dclmcloud.s3.amazonaws.com/img/logo.png" width="206.5" height="190"></a></p>

## DCLM Testimony
This is a laravel app to collect testimonies from our online community and global audience.

App url: [DCLM Testimony](https://testimony.dclm.org)

## How to Run

<a id="mac-setup"></a>
### On MacOS (Docker)
- make sure you have `git` installed
- make sure you have `make` installed. Learn how [here](docs/make.md)
- make sure you have `docker` installed. Learn how [here](https://docs.docker.com/desktop/install/mac-install/)
- make sure you have `docker compose` installed. Learn how [here](https://docs.docker.com/compose/install/)
- create a directory: `mkdir -p <directory-name>`
- run `git config --global core.autocrlf input`
- run `git clone https://github.com/dclmict/dclm-events.git .`
- run `make dev`
- run `make key`
- run `make migrate`
- run `make seed`

<a id="windows-setup"></a>
### On Windows (Docker)
- make sure you have `git` installed
- make sure you have `make` installed. Learn how [here](docs/make.md)
- make sure you have `docker` installed. Learn how [here](https://docs.docker.com/desktop/install/windows-install/)
- make sure you have `docker compose` installed. Learn how [here](https://docs.docker.com/compose/install/)
- create a directory: `mkdir -p <directory-name>`
- run `git clone https://github.com/dclmict/dclm-events.git .`
- run `make dev`
- run `make key`
- run `make migrate`
- run `make seed`

## Credit
App built and released by [DCLM Developers Community](https://developers.dclm.org).
