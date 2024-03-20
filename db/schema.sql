create table if not exists `users`
(
    `id`         integer      not null primary key,
    `name`       varchar(255) not null,
    `email`      varchar(255) not null unique,
    `password`   varchar(255) not null,
    `role`       varchar(255) not null default 'doctor',
    `created_at` timestamp    not null default current_timestamp,
    `updated_at` timestamp    not null default current_timestamp
);

create table if not exists `tokens`
(
    `id`         integer      not null primary key,
    `user_id`    integer      not null,
    `token`      varchar(255) not null unique,
    `is_valid`   boolean      not null default true,
    `created_at` timestamp    not null default current_timestamp,
    `updated_at` timestamp    not null default current_timestamp,
    foreign key (`user_id`) references `users` (`id`)
);

create table parents
(
    id         integer      not null primary key,
    name       varchar(255) not null,
    email      varchar(255) not null unique,
    phone      varchar(255) not null unique,
    address    varchar(255),
    created_at timestamp    not null default current_timestamp,
    updated_at timestamp    not null default current_timestamp
);

create table kids
(
    id         integer      not null primary key,
    name       varchar(255) not null,
    dob        date,
    parent_id  integer,
    category   varchar(32)  not null,
    created_at timestamp    not null default current_timestamp,
    updated_at timestamp    not null default current_timestamp,
    foreign key (parent_id) references parents (id)
);

create trigger if not exists [UpdateLastTime]
    after
        update
    on `tokens`
    for each row
begin
    update `tokens`
    set `updated_at` = CURRENT_TIMESTAMP
    where RowId = old.RowId;
end;
