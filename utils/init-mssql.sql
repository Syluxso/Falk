create table opt_in_request
(
    id        int identity
        constraint opt_in_request_pk
            primary key,
    site_id   varchar(255) not null,
    site_name varchar(255) not null,
    phone     bigint       not null,
    status    tinyint      not null,
    created   int          not null,
    hash      varchar(255) not null,
    constraint opt_in_request_uk
        unique (site_id, site_name, phone)
)
go

