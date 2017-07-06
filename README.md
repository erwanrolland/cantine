## About
Cantine is a project that allows you to register for lunch.
You can manage accounts according food shopping and the number of meals eaten.

## Install 

``` 
composer install 
bin/console doctrine:database:create
bin/console doctrine:schema:update --force
bin/console server:start

```

## Use

Create user in  http://127.0.0.1:8000/admin/er/cantine/utilisateur/create

You can start  http://127.0.0.1:8000/