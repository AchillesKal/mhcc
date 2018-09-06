# MHCC

This is a Symfony coding challenge project.

## Getting Started

This project ships with [devilbox](https://github.com/cytopia/devilbox) as a development environment.
Instruction on how to setup and use devilbox [here](https://devilbox.readthedocs.io/en/latest/getting-started/install-the-devilbox.html)

This project also uses Symfony4.

The symfony code lives data/www/mhcc/symfony directory.

## Install project

1. Clone the repository.

```
git clone https://github.com/AchillesKal/mhcc.git
```

2. Change directory.

```
cd mhcc
```

Create .env file.

```
cp env-example .env
```

Set uid and gid

In .env there are only two variables that need to be adjusted:

* ``NEW_UID``
* ``NEW_GID``

In most cases both values will be ``1000``.


Run docker multi-container Docker application:
```
docker-compose up
```

Now devilbox should be up and running.  
Check out your http://localhost  
If you see the devlibox dashboard, you've just set up the development environment, congratulations!

### Setup Symfony

1. Enter the PHP container
--------------------------

All work will be done inside the PHP container as it provides you with all required command line
tools.  

Navigate to the Devilbox git directory and execute ``shell.sh`` (or ``shell.bat`` on Windows) to
enter the running PHP container.  

```
./shell.sh
```

2. Install Symfony Dependencies
-------------------------------

Navigate into the symfony installation dyrectory inside the PHP container.

```
devilbox@php-7.0.20 in /shared/httpd $  cd mhcc/symfony/  # /shared/httpd/mhcc/symfony/
```

Install dependencies with composer:

```
devilbox@php-7.0.20 in /shared/httpd/my-symfony $ composer install
```

3. Setup database and fixtures.

Navigate into the symfony installation directory inside the PHP container.

```
cd /shared/httpd/mhcc/symfony
```

And run:

```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```


4. DNS record
-------------

If you **have** Auto DNS configured already, you can skip this section, because DNS entries will
be available automatically by the bundled DNS server.

If you **don't have** Auto DNS configured, you will need to add the following line to your
host operating systems ``/etc/hosts`` file (or ``C:\Windows\System32\drivers\etc`` on Windows):

On your host machine in /etc/hosts
```
127.0.0.1 mhcc.loc
```


5. Open your browser
--------------------

Open your browser at http://mhcc.loc


## Running the tests

1. Navigate into the symfony installation directory inside the PHP container.

```
cd /shared/httpd/mhcc/symfony
```

Manually create the var/data directory:
```
mkdir var/data
```

2. To create the testing database run:

```
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:create --env=test
```

3. To install all the test dependencies and execute the tests, run:
```
php bin/phpunit
```

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
