[![pipeline status](https://git.codenetix.com/dms/backend/badges/master/pipeline.svg)](https://git.codenetix.com/dms/backend/commits/master)
[![coverage report](https://git.codenetix.com/dms/backend/badges/master/coverage.svg)](https://git.codenetix.com/dms/backend/commits/master)


[![Codenetix](https://www.codenetix.com/img/codenetix-logo-light.svg)](https://www.codenetix.com/)

## Installation

### Production

- Download base docker-compose file
    > curl //TODO

- Override it with your environments

- Initiate database migrations and seeders (only once before first start)
    > docker-compose up init

- Start application
    > docker-compose up -d backend-app

### Develop
- Clone repository

- Initiate database migrations and seeders (only once before first start)
    > make init_dev

- Start application
    > make up_dev

- Run tests
    > make test