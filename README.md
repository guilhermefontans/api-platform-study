#### Description
This repository is result of a course that i studied on SymfonyCasts about the tool [Api Platform](https://api-platform.com/). 

#### Tecnologies used

#### Requirements
* [Docker](https://docs.docker.com/install/linux/docker-ce/debian/)
* [Docker Compose](https://docs.docker.com/compose/install/)
* [Yarn](https://yarnpkg.com/getting-started/install)

#### Instalation

1. Rename the .env.dist to .env amd replace the variables in the file according your configuration.
```sh
cp .env.dist .env
```

2. Install composer dependencies required
```sh
docker run  --rm  --volume $PWD:/app --user $(id -u):$(id -g)   composer install --ignore-platform-reqs
```
3. Create the database that will be used
```sh
docker exec -t api-platform php bin/console doctrine:database:create
```
3. Create the tables that will be used
```sh
docker exec -t api-platform php bin/console doctrine:schema:create
```
4. Install Vue dependencies
```sh
yarn
```
5. Build the frontend files
```sh
yarn build
```
6. Run the application
```sh
docker-compose up -d
``` 

After do this steps above, access http://localhost:8000/api to see the docs
