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

create table if not exists parents
(
    id         integer      not null primary key,
    name       varchar(255) not null,
    email      varchar(255) not null unique,
    phone      varchar(255) not null unique,
    address    varchar(255),
    created_at timestamp    not null default current_timestamp,
    updated_at timestamp    not null default current_timestamp
);

create table doctors
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


create table appointments
(
    id         integer     not null primary key,
    kid_id     integer     not null,
    doctor_id  integer     not null,
    date       date        not null,
    time       time        not null,
    reason     text        not null,
    status     varchar(32) not null default 'pending',
    created_at timestamp   not null default current_timestamp,
    updated_at timestamp   not null default current_timestamp,
    foreign key (kid_id) references kids (id),
    foreign key (doctor_id) references users (id)
);

create trigger if not exists [UpdateTokensLastTime]
    after
        update
    on `tokens`
    for each row
begin
    update `tokens`
    set `updated_at` = CURRENT_TIMESTAMP
    where RowId = old.RowId;
end;

create trigger if not exists [UpdateUsersLastTime]
    after
        update
    on `users`
    for each row
begin
    update `users`
    set `updated_at` = CURRENT_TIMESTAMP
    where RowId = old.RowId;
end;

create trigger if not exists [UpdateParentsLastTime]
    after
        update
    on `parents`
    for each row
begin
    update `parents`
    set `updated_at` = CURRENT_TIMESTAMP
    where RowId = old.RowId;
end;

create trigger if not exists [UpdateKidsLastTime]
    after
        update
    on `kids`
    for each row
begin
    update `kids`
    set `updated_at` = CURRENT_TIMESTAMP
    where RowId = old.RowId;
end;

create trigger if not exists [UpdateAppointmentsLastTime]
    after
        update
    on `appointments`
    for each row
begin
    update `appointments`
    set `updated_at` = CURRENT_TIMESTAMP
    where RowId = old.RowId;
end;

create trigger if not exists [UpdateDoctorsLastTime]
    after
        update
    on `doctors`
    for each row
begin
    update `doctors`
    set `updated_at` = CURRENT_TIMESTAMP
    where RowId = old.RowId;
end;