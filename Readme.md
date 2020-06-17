### Execute following command in a terminal to spin up the project

```bash
# Clone repository
git clone git@github.com:gayansanjeewa/AcmeBookStore.git TestAcmeBookStore

# Navigate into the cloned directory
cd TestAcmeBookStore

# You can find a convenient set of commands by executing "make"
☁  AcmeBookStore [master] make
Available Commands:
help                           Shows all available commands with their description
ps                             List containers
build                          Builds the docker images and executes the vendors
up                             Builds, (re)creates, starts, and attaches to containers for a service
composer                       Allow to use the composer commands. Usage: make composer i='require symfony/assets'
test                           Run test
fix-cs                         Runs the code style fixer
check-cs                       Dry-run the code style fixer and provide diff if available
sh                             Gets inside a container, use 'i' variable to select a service. Usage: make sh i=app
app                            Gets inside app container, use 'i' variable to select a service. Usage: make sh i="php bin/console"
logs                           Shows the logs of a container. Use 'i' variable to filter on a specific container. Usage: make logs i=app
☁  AcmeBookStore [master]

# To download the docker images execute "make build"
make build

# To spin up the docker containers and crate the docker environment execute "make up"
make up
```

If you see a similar output like below, it's a sign that the environment up and running

```bash
☁  TestAcmeBookStore [master] ⚡  make up                                                     
Creating network "testacmebookstore_default" with the default driver
Creating acmebookstore_mysql ... done
Creating acmebookstore_app     ... done
Creating acmebookstore_adminer ... done
Creating acmebookstore_nginx   ... done
        Name                       Command               State                      Ports                   
------------------------------------------------------------------------------------------------------------
acmebookstore_adminer   entrypoint.sh docker-php-e ...   Up      0.0.0.0:8008->8080/tcp                     
acmebookstore_app       docker-php-entrypoint php- ...   Up      9000/tcp                                   
acmebookstore_mysql     docker-entrypoint.sh --def ...   Up      3306/tcp, 33060/tcp                        
acmebookstore_nginx     /docker-entrypoint.sh ngin ...   Up      0.0.0.0:3043->443/tcp, 0.0.0.0:8000->80/tcp
☁  TestAcmeBookStore [master] ⚡
```

Open adminer in http://localhost:8008/?server=mysql&username=admin&db=acme_book_store_test

You'd find a sample databasse dump for the purpose to this project in `migrations/acme_book_store_test.sql`. Export it using adminer

Navigate to http://localhost:8000 and you'd see the website up and running

#### Some useful console outputs:
```bash
☁  AcmeBookStore [master] ⚡  make test
Starting acmebookstore_mysql ... done
PHPUnit 7.5.20 by Sebastian Bergmann and contributors.

Testing Project Test Suite
.........                                                           9 / 9 (100%)

Time: 303 ms, Memory: 12.00 MB

OK (9 tests, 41 assertions)
☁  AcmeBookStore [master] ⚡ 
```

```bash
☁  AcmeBookStore [master] ⚡  make check-cs
Starting acmebookstore_mysql ... done
Loaded config default from ".php_cs.dist".
Using cache file ".php_cs.cache".
SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS                                                                                                                                          33 / 33 (100%)
Legend: ?-unknown, I-invalid file syntax (file ignored), S-skipped (cached or empty file), .-no changes, F-fixed, E-error

Checked all files in 0.002 seconds, 6.000 MB memory used
☁  AcmeBookStore [master] ⚡
```