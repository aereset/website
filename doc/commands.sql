--
-- Create the user that will have access to the database.
--
create user 'reset'@'localhost' identified by '1234';

--
-- Create the actual database.
--
create database reset character set utf8 collate utf8_general_ci;

--
-- Set user permissions.
--
grant select,insert,delete,update on reset.* to reset identified by '1234';

--
-- Use the new database.
--
use reset;

--
-- The users table contains all the registered users (name and hashed
-- password) and an automatically assigned unsigned ID to be used as key
-- in other tables.
--
create table users(
	number int unsigned not null auto_increment primary key,
	id char(20) not null unique,
	password char(128) not null
);

--
-- This table registers log in events and the moment when they occured.
--
create table session_log(
	user int unsigned not null,
	date datetime not null,
	primary key (user,date)
);

--
-- The invitation table contains all the invitations, with the
-- expiration date, the invitation key and a boolean variable that will
-- be set to '1' once the invitation has been used. It also contains
-- the permissions that will be given to the new user, separated by
-- commas.
--
create table invitations(
	user int unsigned not null,
	invitation_key char(128) not null,
	expiration datetime not null,
	permissions text(500),
	used_by char(20)
);

--
-- The permissions table contains the users permissions. The admin
-- permissions (set bellow tables creation) should be modified if this
-- table is changed!
--
create table permissions(
	user int unsigned not null primary key,
	admin bool default 0,
	invitations bool default 0,
	banners bool default 0,
	news bool default 0,
	wiki bool default 0
);

create table user_info(
	user int unsigned not null primary key,
	name char(30) not null,
	surname char(60) not null,
	birth date not null,
	country char(20) not null,
	email char(50) not null
);

--
-- Create admin user with password "admin" (not salted!).
--
insert into users (id,password) values ('admin','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec');

--
-- Set permissions to user "admin.
--
insert into permissions (user,admin,invitations,banners,news,wiki) values ('1','1','1','1','1','1');
