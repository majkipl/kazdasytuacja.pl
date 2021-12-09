#!/bin/bash

composer install --no-interaction --no-progress

npm install -g npm@9.7.2
npm install
npm run build

php bin/console cache:clear
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction

# utrzymuje kontener przy życiu - nie zamyka apache
# wyświetla logi apacha
exec docker-php-entrypoint apache2-foreground