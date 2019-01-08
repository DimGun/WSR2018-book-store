Simlple REST API implementation using Laravel framework.

## Disclaimer
My nephew asked to help her with a grade work she was assigned at high school.
It was based on WORLDSKILLRUSSIA2018 championship.
I never worked with PHP professionaly, so it was my very first experience implementing something using this stack.
So if you're searching for 'best practice', 'production ready', etc. solution, then you're in a wrong place.
I tried to keep everithing simple stupid as much as possible.
I was making commits and feature branches a lot, to make it easier to get an idea of the implementation stages.
I also added `.evn` to repository, so it would be easier to launch a project without any additional modifications.

## Prerequisite 
In order to simplify initial setup I used preconfigured docker image, provided by Laradock (you can find more at https://laradock.io/).
To run this example you need to install Docker and Docker Compose, or manually setup PHP server.

## Usage
Checkout the repository.
Open terminal of your choice, then do following:
```bash
cd book-store/
git submodules --init
cd laradock
docker-compose up -d nginx
```
Then you need to initialize database, I used SQLite in this example (remember KISS).
But you can easily spin a mysql instance using laradock and connect to it by changing connection options in the `.env`.
To setup a database do the following:
```bash
docker-compose exec workspace bash
```
This will connect you to the `workspace` container created by laradock, where you can run `php artisan` commands and interact with the server.
Now run
```bash
php artisan migrate
```
After this you should be able to interact with the API on your host machine.
For example, you could open a browser and check `http://localhost/api/books` it should respond with
```json
{
  'status': true,
  'books': []
}
```

You could also make requests with `curl` from your host machine.
There are some examples for your reference:
```bash
# get list of books
curl -XGET http://localhost/api/books/ -H "Accept: application/json"

# get a single book by its id
curl -XGET -H "Accept: application/json" http://localhost/api/books/1

# create a new book
curl -XPOST http://localhost/api/books -H "Accept: application/json" -F 'title=Robinson Crusoe' -F 'anons=Ship drowns during a thunderstorm, only one man survives...' -F 'image=http://localhost/images/img0.jpg'

# update the book
curl -XPUT http://localhost/api/books/1 -H "Accept: application/json" -d 'title=Robinson Crusoe by D.Defoe' -d 'anons=Ship drowns during a thunderstorm, only one man survives...' -d 'image=http://localhost/images/img0.jpg'

# delete an existing book
curl -XDELETE -H "Accept: application/json" http://localhost/api/books/1
```
