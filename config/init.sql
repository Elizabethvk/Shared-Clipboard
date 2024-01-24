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

    constraint pk_user primary key (id)
);

create table if not exists auth_token(
    id int unique not null auto_increment,
    user_id int not null,
    token varchar(255) not null,
    expires_at timestamp not null,
    
    primary key (id),
    foreign key (user_id) references user(id)
);

-- Semantic - subscriber is following the user
create table if not exists subscription(
	subscriber_id int not null,
	user_id int not null,
    created_at timestamp not null default now(),

	primary key (subscriber_id, user_id)
);

create table if not exists clip(
    id int unique not null auto_increment,
    name varchar(255) not null,
    description text,
    resource_type varchar(63) not null,
    resource_data text,
    is_public boolean not null default true,
    owner_id int not null,

    uploaded_at timestamp not null default now(),
    last_updated_at timestamp not null default now(),
    
    primary key (id),
    foreign key (owner_id) references user(id)
);

