# Locations API

An API that returns Location points for a region on a map

----------

## Getting started

Please check the [official Laravel installation guide](https://laravel.com/docs/10.x/installation).

Install the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (*Set the database connection in .env before migrating*)

    # run php artisan migrate:install first if there is no migrations table yet
    php artisan migrate

Run the seeders to populate the `locations` table with the data from the `database/csv/data.csv`. The `LocationSeeder` truncates the table before seeding.

    php artisan db:seed

Launch the server

    php artisan serve

## API Reference

#### Gets the locations that fall within the given radius of the given coordinates

```http
  GET /api/locations
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `latitude` | `float` | **Required**. The latitude of the start point of the radius. |
| `longitude` | `float` | **Required**. The longitude of the start point of the radius. |
| `radius` | `int` | **Required**. The radius distance. |
| `radiusUnit` | `string` | The unit of measurement of the radius. It can either be "km" or "mi". |

## Tests

To run tests, run the following command

```
  php artisan test
```
