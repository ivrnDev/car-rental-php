Car Availability Status: 0 = Pending, 1 = Available, 2 = On lease, 3 - Maintenance 4 - Rejected 5 - Cancelled

Car status = 0 = Pending, 1 = Approve = 2 = Rejected 3 = Cancelled

Car Payment Status = 0 - Pending, 1 = Processing 2 =Paid, 3 = Unpaid 4 - Free Trial 5 - Cancelled

Rent Status: 0 = Pending, 1 = Approve, 2 = Rejected, 3 = Contact Processing, 4 = Transferring Process, 5 = On Going, 6 = Return Processing 7 = On Hold 8 = Completed, 9 - Under Review, 10 - Cancelled

User Status = 0 Pending, 1 Approve, 2 Rejected, 3- BlackListed

Role = 0 - Admin, 

select * from car;
select * from "DOCUMENT";
select * from "USER";
select * from rent;
select * from rate;

delete from car;
delete from "DOCUMENT";
delete from "USER" where user_id != 1000;
delete from rent;
delete from rate;

describe car;
describe "DOCUMENT";
describe "USER";
describe rent;
describe rate;

alter sequence user_seq restart start with 1001 increment by 1;
alter sequence rent_seq restart start with 10000 increment by 1;
alter sequence car_seq restart start with 1 increment by 1;
alter sequence document_seq restart start with 1 increment by 1;
alter sequence rate_seq restart start with 1 increment by 1;

CREATE TABLE "USER" (
user_id int PRIMARY KEY,
first_name varchar(255),
last_name varchar(255),
middle_name varchar(255),
contact_number int,
address varchar(255),
gender int,
email_address varchar(255),
password varchar(255),
user_role int,
status int,
)

CREATE TABLE Car (
car_id int PRIMARY KEY,
car_model varchar(255),
car_color varchar(255),
car_brand varchar(255),
plate_number varchar(255),
seat_capacity int,
gas_type varchar(255),
availability_status int,
status int,
owner_id int,
FOREIGN KEY owner_id REFERENCES "USER" (user_id),  
)

CREATE TABLE "DOCUMENT" (
document_id int PRIMARY KEY,
document_name varchar(255),
document_type varchar(255),
file_name varchar(255),
file_link varchar(255)
user_id int,
car_id int,
FOREIGN KEY user_id REFERENCES "USER" (user_id),  
 FOREIGN KEY car_id REFERENCES Car (car_id)

)

CREATE TABLE Rent (
rent_id int PRIMARY KEY,
user_id int,
owner_id int,
car_id int,
pick_up_time timestamp,
return_time timestamp,
rent_date_from date,
rent_date_to date,
status int,
transaction_date date,
FOREIGN KEY user_id REFERENCES "USER" (user_id),  
 FOREIGN KEY owner_id REFERENCES "USER" (user_id)

)

CREATE TABLE Rate (
rate_id int PRIMARY KEY,
car_id int,
user_id int,
rate_count int,
rate_comment varchar(255),
rate_time timestamp,
FOREIGN KEY (car_id) REFERENCES Car(car_id),
FOREIGN KEY (user_id) REFERENCES "USER"(user_id)
)

CREATE TABLE Payment (
    payment_id int PRIMARY KEY,
    car_id int,
    payment_amount int,
    paid_amount int,
    payment_status int,
    transaction_date timestamp,
    FOREIGN KEY (car_id) REFERENCES Car (car_id)
)
