
# Steps to start the application
Please run the following steps to start the project in local environment.

## Prerequisites: (Please ignore if all packages are already installed)
1. Please install make if it is not installed in your system: 
   1. Ubuntu:
   ```
   sudo apt update
   sudo apt-get install make
   ```
   2. CentOs:
   ```
   yum install make
   ```
   3. MacOs
   ```
   brew install make
   ```
2. Please install docker and docker-compose:

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
   git checkout -b lmw-exercise-sf-logics origin/lmw-exercise-sf-logics
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
7. Give permission to the storage logs and cache:
   ```
   make set-storage-permission
   ```
7. Now the environment will be ready to accept HTTP requests. API host:
   http://localhost/
   or
   http://lmw.local.com/

To test the project with PostMan, exported json setup will be provided manually.