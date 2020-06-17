### Execute following command in a terminal to spin up the project

```bash
# Clone repository
git clone git@github.com:gayansanjeewa/AcmeBookStore.git TestAcmeBookStore

# Navigate into the cloned directory
cd TestAcmeBookStore

# You can find a convenient set of commands by executing "make"
make

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

#### Note:
Please note from the assignment 
- couple of tests are still missing
- the checkout page not yet complete