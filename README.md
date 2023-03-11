# php-sql_asg1
Assigment: https://www.wa4e.com/assn/autosdb/

# SQL-code:
create database Assigment_2;
use Assigment_2;
CREATE USER 'user'@'localhost' IDENTIFIED BY 'inspiron';
grant all on Assigment_2.* to 'user'@'localhost';

create table autos (
   auto_id int unsigned not null auto_increment primary key,
   make varchar(128),
   year int,
   mileage int
);
