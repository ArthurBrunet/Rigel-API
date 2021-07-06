# Welcome to Rigel !
This is the API part used with Symfony.
## Contributors :

- [Arthur Brunet](https://github.com/AhmedBouk)
- [Baptiste Angot](https://github.com/BaptisteAngot)
- [Mathias Delpey](https://github.com/mathD92)
- [Léo Fouquier](https://github.com/novaedra)
- [Nicolas Becuwe](https://github.com/NikoFLK)
- [Turpin Paul](https://github.com/Druxys)

## Requirements :
Prerequisites for the proper functioning of the application
- [PHP 7.2](https://lmgtfy.com/?q=How%20to%20get%20php%207.2&iie=1)
- [Composer](https://getcomposer.org/)
- [Symfony 4.4](https://symfony.com/)

## Installation
Get the project :

    git clone git@github.com:ArthurBrunet/Rigel-API.git

Install bundles with composer :

    composer install

Generate the SSH keys :

    mkdir -p config/jwt 
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

Create an .env.local, add your database URL & your SSH keys configuration. It look like this :

    DATABASE_URL=postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=11&charset=utf8 
    JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem 
    JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem 
    JWT_PASSPHRASE=*yourPassphrase*

Create your Postgres database with the following commands:

    php bin/console make:migration
    php bin/console doctrine:migrations:migrate

Launch Symfony with the following command :

    php -S localhost:8000 -t public

Create an User Admin:

    php bin/console create:admin:user

## Complementary Informations :
Dependencies/Bundles used :

- [Doctrine](https://symfony.com/doc/5.0/doctrine.html)
- [lexik/LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle)
