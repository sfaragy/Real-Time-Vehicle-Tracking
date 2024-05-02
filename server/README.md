
This is a boilerplate for a test exercise:
``` 
Using Laravel 11
Mongodb
Redis
PHP8.3-fpm
Nginx
```

MongoDB is running in a different container as per my exercise. If anyone want to add it in the same project then please add the following in docker-compose.yml

```
  mongo:
    image: mongo:latest
    ports:
      - '27017:27017'
    volumes:
      - mongo-data:/data/db
    networks:
      - my-network

volumes:
  mongo-data:
```

To build the application:
``` make build ```

To start the application:
``` make start ```

   https://docs.docker.com/engine/install/

   https://docs.docker.com/compose/install/

## Build and run the project in docker container:
1. Clone the repository:
   ``` 
   mkdir lmw
   cd lmw
   git clone git@github.com:teamups-dev/teamups-tech-x-65c51a54060226c992f285aa-65c549fc060226c992f285b4-661977a1268087ffb90acc07.git .
   ```
2. Checkout to the following branch:
   ```
   git checkout -b lmw-exercise-sf-base origin/lmw-exercise-sf-logics
   git pull
   ```
3. Change control to the server:
   ``` 
   cd server
   ```
4. Build docker images:

   ```
   make build 
   ```
5. Two env files will create automatically in the server/lmw/ directory. Copy content to the env files respectively from private google drive. ```https://drive.google.com/drive/folders/1FbAwkREp9yBnojInmMsOjw62kInR3vWt```
    1. .env
    2. .env.testing


6. Migrate and seed initial database:

   ```
   make migrate
   ```
7. Give permission to the storage logs and cache: (If any permission error appears)
   ```
   make set-storage-permission
   ```
7. Now the environment will be ready to accept HTTP requests. API host:
   http://localhost/
   or
   http://lmw.local.com/

To test the project with PostMan, exported json setup will be provided manually.