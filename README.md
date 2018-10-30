# api-recommerce
Study case for Recommerce


## How to Install

# With Docker

Run `docker-compose build` at the root of the project
Then `docker-compose up -d`

Go to `/api` and run `composer install`

Go back to the root of the project then:
`docker-compose exec php bash`
`php doctrine:migration:migrate` to create the Schema

Run to `localhost:8080` to access to Adminer (db : recommerce and login/password root/root)
Run to `localhost/api/doc` for the documentation of the API.