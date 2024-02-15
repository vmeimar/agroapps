## About the Application

This application gathers and saves weather data (temperature and precipitation).
The data are gathered from 2 different weather APIs, https://open-meteo.com/ and https://www.weatherapi.com/.

To install & run the application, please do the following:

- Clone the repository:
  - ``git clone https://github.com/vmeimar/agroapps.git``
- Move inside project root:
  - cd agroapps
- Deploy project with docker:
  - ``docker run --rm --interactive --tty \
    --volume $PWD:/app \
    --user $(id -u):$(id -g) \
    composer install``
- Copy the .env settings:
  - ``cp .env.example .env``
- Get the container up:
  - ``vendor/bin/sail up -d``
- Generate Laravel's app key:
  - ``vendor/bin/sail artisan key:generate``
- Run the database migrations with seeder:
  - ``vendor/bin/sail artisan migrate --seed``*
- The two following commands can be used to fetch and save weather data for one or multiple locations:
  - ``vendor/bin/sail artisan app:fetch-weather-data {locationName}``**
  - ``vendor/bin/sail artisan app:fetch-weather-data --locations=all``
- Run tests:
  - ``vendor/bin/sail artisan test``

The console command is triggered by a scheduler every day at 00:00.
In order to deploy the scheduler, we should create the cron inside our server enviroment.

*The database seeder will create two locations, Athens and Paris.
If we try to run the command with an unknown location (not existing in DB)
we should get an error.

** example: ``vendor/bin/sail artisan app:fetch-weather-data Athens``

### API endpoints

The following endpoints have been implemented:

**Create new location:**

POST ``http://localhost/api/location``


**Update a location:**

PUT ``http://localhost/api/location/{location_id}``

json body:
``{
"name":"Prague",
"latitude":"50.08",
"longitude":"14.47"
}``

**Index Locations**

GET ``http://localhost/api/location``


**Index WeatherAPI Data**

GET ``http://localhost/api/weather-api/``

**Index OpenMeteo Data**

GET ``http://localhost/api/open-meteo/``
