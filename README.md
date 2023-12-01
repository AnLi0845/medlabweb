# medlabweb

## How to use (MacOS and Window platform)

- Run this commmand to bring up the docker image
```
docker compose up
```

- Access the Web server with:
```
http://localhost
```

- phpmyadmin can be access with:
```
http://localhost:8080
```

## How to use (Liunx platform)

- Remove all the file from mysql
```
cd /medlabweb
rm -rf /mysql
```

- Run this commmand to bring up the docker image
```
docker compose up
```

- From MySQL container, or phpmyadmin web interface recreate the database using the .sql file.
  - CreateTablev3.sql
  - InserData_v3.sql
  - DecryptData_v3.sql
  - Privilege_v3.sql

- Access the Web server with:
```
http://localhost
```

- phpmyadmin can be access with:
```
http://localhost:8080
```
## Directory 

- www/
  - contain the front-end source code
- mysql/
  - cotain the mysql database config and data that front-end will use


## Account 

- phpmyadmin
  - username: root
  - password: password

- Web Application test user
  - username: alexj85
  - password: Alex123
