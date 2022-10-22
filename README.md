# Symfony test
This is a simple test to use Symfony routes and create a little parser of an external API that use timestamp in the request to a more familiar date type (YYYY-MM-DD).

## Run server
To start the server the easy way is with the next bash commands in the root of the project.
```
composer install
cd public
php -S localhost:8000
```

## API
The api only contains one demo endpoint:

``` bash
{{ssl}}{{domain}}/api/{{tagged-slug}}?fromdate={{fromdate-optional}}&todate={{todate-optional}}
```
Example:

``` bash
localhost:8000/api/php?fromdate=2022-10-22&todate=2022-10-24
```
