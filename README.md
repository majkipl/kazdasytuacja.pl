# Tutorials

Well hi there! This repository holds the code and script.

## Docker

Open a terminal or command prompt and go to the root of the Symfony application.

Run the following command in the terminal:

```
docker-compose up -d
```

Docker will build the container from the Dockerfile and docker-compose.yml files and run the Symfony application in the container.

## Setup

If you've just downloaded the code, congratulations!!

To get it working, follow these steps:

**Download Composer dependencies**

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

**Start the Symfony web server**

Then, to start the web server, open a terminal, move into the
project, and run:

```
npm run build
cd public
php -S localhost:8008
```

By default, messages are handled as soon as they are dispatched. If you want to handle a message asynchronously, run:

```
php bin\console messenger:consume async
```


## Thanks!