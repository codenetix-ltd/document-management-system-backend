[![pipeline status](https://git.codenetix.com/dms/backend/badges/master/pipeline.svg)](https://git.codenetix.com/dms/backend/commits/master)
[![coverage report](https://git.codenetix.com/dms/backend/badges/master/coverage.svg)](https://git.codenetix.com/dms/backend/commits/master)


[![Codenetix](https://www.codenetix.com/img/codenetix-logo-light.svg)](https://www.codenetix.com/)

## Installation

1. Clone repository

2. Start application
    ```bash
    make up_dev
    ```
3. Initiate database migrations and seeders (only once before first start)
    ```bash
    make init_dev
    ```
4. Run tests
    ```bash
    make test
    ```