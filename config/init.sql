create database if not exists clipboard;

use clipboard;

create table if not exists `user`(
    id          int unique not null auto_increment,
    email       text unique not null,
    username    text unique not null,
    password    text not null,
    is_admin    boolean not null default false,

    -- Auditing fields
    created_at timestamp not null default now(),
    last_updated_at timestamp not null default now(),

    -- Soft deletion
    is_deleted boolean not null default false,

    constaint pk_user primary key (id)
);

-- Semantic - subscriber is following the user
create table if not exists subscription(
	subscriber_id int not null,
	user_id int not null,
    created_at timestamp not null default now(),

	PRIMARY KEY (subscriber_id, user_id)
);