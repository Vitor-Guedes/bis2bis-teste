create database if not exists `blog`;

use `blog`;

create table if not exists `admin_user` (
    `id` int primary key auto_increment,
    `username` varchar (150) not null,
    `password` varchar (150) not null
)engine=innodb;

create table if not exists `visitor_user` (
    `id` int primary key auto_increment,
    `username` varchar (150) not null,
    `email` varchar (150) not null,
    `password` varchar (150) not null,
    `active` int default 1
)engine=innodb;

create table if not exists `post` (
    `id` int primary key auto_increment,
    `user_id` int,
    `title` varchar (150) not null,
    `content` varchar (150) not null,
    `created_at` timestamp default now(),
    `updated_at` timestamp null,
    `publish` int default 1,
    foreign key (`user_id`) references `visitor_user` (`id`) on delete cascade
)engine=innodb;

insert into `admin_user` (username, password) values ('admin', 'admin');