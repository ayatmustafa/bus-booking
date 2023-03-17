## About task

Task Description
Robusta studio wants to build a fleet-management system (bus-booking system) Having:
1- Egypt cities as stations [Cairo, Giza, AlFayyum, AlMinya, Asyut...]
2- Predefined trips between 2 stations that cross over in-between stations.
ex: Cairo to Asyut trip that crosses over AlFayyum -firstly- then AlMinya.
3- Bus for each trip, each bus has 12 available seats to be booked by users, each seat has an
unique id.
4- Users can book an available trip seat.
For example we have Cairo-Asyut trip that crosses over AlFayyum -firstly- then AlMinya:
any user can book a seat for any of these criteria
(Cairo to AlFayyum), (Cairo to AlMinya), (Cairo to Asyut),
(AlFayyum to AlMinya), (AlFayyum to Asyut) or
(AlMinya to Asyut)
if there is an available seat, taking into consideration if the bus is full from Cairo to
AlMinya, the user cannot book any seat from AlFayyum but he can book from AlMinya.
We require the following:
Implement a solution for this case using a Relational-Database and Laravel web app that
provides 2 APIs for any consumer(ex: web app, mobile app,...)
● User can book a seat if there is an available seat.
● User can get a list of available seats to be booked for his trip by sending start and end
stations.
** Bonus: Implement proper unit tests are available.


<h2 align="center"><a href="https://documenter.getpostman.com/view/9536988/2s93JzKLEQ" target="_blank">Postman Documentation</a></h2>

## Requirements
php 8.2
mysql 
apache server
SQLite for testing
### What We Need To Run Task 
- Clone the project 
- Run (composer install) 
- Run  (cp .env.example .env)  to generate .env
- Open .env and add setting of data base that in project in database folder 
- Run php artisan key:generate
- Run php artisan migrate:fresh --seed
- Run php artisan passport:install
- Run php artisan optimize:clear
- Run php artisan serve
- Run sudo apt-get install php8.2-sqlite3
- Run php artisan test
### endpoints 
- register:
 /api/register
 post method
{
    "name":"test",
    "email":"test@gmail.com",
    "password":"12345678"
}
- login:
 /api/login
 post method
{
     "email":"test@gmail.com",
    "password":"12345678"
}
- get available seats between two stations
/api/get-available-seats g
get method 
{
    "start_station":1,
    "end_station":2
}
- book specific seat in specific trip
/api/booking-seat
post method
{
    "seat_number":"2_1",
    "start_station":5,
    "end_station":7,
    "trip_id":1

}
- logout
api/logout
