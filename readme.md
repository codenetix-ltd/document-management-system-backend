[![pipeline status](https://git.codenetix.com/dms/backend/badges/master/pipeline.svg)](https://git.codenetix.com/dms/backend/commits/master)
[![coverage report](https://git.codenetix.com/dms/backend/badges/master/coverage.svg)](https://git.codenetix.com/dms/backend/commits/master)

Installation guide
---------------------
#### Project local initialization

Clone project

    $ mkdir /project && cd "$_"
    $ git clone git@gitlab.com:digitalplatform/backend.git .
    
Build Laravel-DMS image

    $ docker build . -t laravel-dms
    
Run MYSQL container don't forget to share docker root project dir if you're using OS X 

    $ docker run --name mysql -v $(pwd -P)/data/mysql:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=JV4yLWsPlzQkCvMz3E5j -e MYSQL_DATABASE=laraveldms -d -p 3306:3306 mysql:latest

Run Laravel-DMS container

    $ docker run -d -ti --link mysql:mysql -v $(pwd -P):/var/www --name laravel-dms --restart=always -p 80:80 -e APP_DEBUG=true -e APP_ENV=dev -e DB_HOST=mysql -e DB_DATABASE=laraveldms -e DB_USERNAME=root -e APP_KEY="base64:N5A11hYX5GxzTqEPRtoRHjtdtqg65hGpw2Qis1V4b8M=" -e DB_PASSWORD=JV4yLWsPlzQkCvMz3E5j laravel-dms
    
#### First start
   
 TODO
   
#### Docker helpers 

    $ docker rm $(docker ps -a -q) -f # remove all containers
    $ docker volume rm `docker volume ls -q -f dangling=true` # remove all dangling volumes
    $ docker rmi $(docker images -q) # remove all images
    
#### Servers

* Dev - http://128.199.214.52