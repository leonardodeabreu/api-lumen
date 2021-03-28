# Leonardo API

Repository hosting the Leonardo's api

## Summary

- Project Requirements
- Getting Started
  - Project Cloning & Build
  - Environment Set Up
  - Database Set Up

## Project Requirements

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/gettingstarted)
- [Git](https://git-scm.com/downloads)
- [Postman](https://www.getpostman.com/apps)

## Getting Started
### 1. Project Cloning & Build
  **1.1.** Clone the repository:

  ```
   # git clone git@github.com:leonardodeabreu/api-lumen.git
   # git checkout main
  ```

  **1.2.** Build & Run the project using Docker Container:

  ```
   # docker-compose up --build
  ```

### 2. Environment Set Up
  **2.1.** Create your local environment settings file:

  ```
   # cd /src
   # cp .env.example .env
  ```

  **2.2.** Review all database-related settings (`DB_*`)

  Replace the `DB_HOST` value with either your local database host address or the Docker Container's IP Address.*

### 3. Database Set Up
**3.1.** Create your database:

  ```
   # docker-compose exec postgres bash
   # psql -U postgres
   # create database develop;
   # \connect develop;
   # create schema develop;
  ```

**3.2.** Run all Migrations:

  ```
   # docker-compose exec php bash
   # composer install
   # php artisan migrate
  ```

The Application will run on port 9090.
