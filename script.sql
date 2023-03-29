create table migrations
(
    id        serial       not null
        constraint migrations_pkey
            primary key,
    migration varchar(255) not null,
    batch     integer      not null
);

alter table migrations
    owner to noveladmin;

create table users
(
    id                  bigserial    not null
        constraint users_pkey
            primary key,
    user_type_id        bigint       not null,
    first_name          varchar(255) not null,
    last_name           varchar(255) not null,
    phone               varchar(255),
    email               varchar(255),
    password            varchar(255),
    profile_picture     varchar(255),
    state_id            bigint,
    local_government_id bigint,
    ward_id             bigint,
    ip                  varchar(255),
    email_verified_at   timestamp(0),
    phone_verified_at   timestamp(0),
    remember_token      varchar(100),
    created_at          timestamp(0),
    updated_at          timestamp(0)
);

alter table users
    owner to noveladmin;

create table password_reset_tokens
(
    email      varchar(255) not null
        constraint password_reset_tokens_pkey
            primary key,
    token      varchar(255) not null,
    created_at timestamp(0)
);

alter table password_reset_tokens
    owner to noveladmin;

create table wallets
(
    id             bigserial                         not null
        constraint wallets_pkey
            primary key,
    holder_type    varchar(255)                      not null,
    holder_id      bigint                            not null,
    name           varchar(255)                      not null,
    slug           varchar(255)                      not null,
    uuid           uuid                              not null
        constraint wallets_uuid_unique
            unique,
    description    varchar(255),
    meta           json,
    balance        numeric(64) default '0'::numeric  not null,
    decimal_places smallint    default '2'::smallint not null,
    created_at     timestamp(0),
    updated_at     timestamp(0),
    constraint wallets_holder_type_holder_id_slug_unique
        unique (holder_type, holder_id, slug)
);

alter table wallets
    owner to noveladmin;

create table transactions
(
    id           bigserial    not null
        constraint transactions_pkey
            primary key,
    payable_type varchar(255) not null,
    payable_id   bigint       not null,
    wallet_id    bigint       not null
        constraint transactions_wallet_id_foreign
            references wallets
            on delete cascade,
    type         varchar(255) not null
        constraint transactions_type_check
            check ((type)::text = ANY ((ARRAY ['deposit'::character varying, 'withdraw'::character varying])::text[])),
    amount       numeric(64)  not null,
    confirmed    boolean      not null,
    meta         json,
    uuid         uuid         not null
        constraint transactions_uuid_unique
            unique,
    created_at   timestamp(0),
    updated_at   timestamp(0)
);

alter table transactions
    owner to noveladmin;

create index transactions_payable_type_payable_id_index
    on transactions (payable_type, payable_id);

create index payable_type_payable_id_ind
    on transactions (payable_type, payable_id);

create index payable_type_ind
    on transactions (payable_type, payable_id, type);

create index payable_confirmed_ind
    on transactions (payable_type, payable_id, confirmed);

create index payable_type_confirmed_ind
    on transactions (payable_type, payable_id, type, confirmed);

create index transactions_type_index
    on transactions (type);

create table transfers
(
    id          bigserial                                          not null
        constraint transfers_pkey
            primary key,
    from_type   varchar(255)                                       not null,
    from_id     bigint                                             not null,
    to_type     varchar(255)                                       not null,
    to_id       bigint                                             not null,
    status      varchar(255) default 'transfer'::character varying not null
        constraint transfers_status_check
            check ((status)::text = ANY
                   ((ARRAY ['exchange'::character varying, 'transfer'::character varying, 'paid'::character varying, 'refund'::character varying, 'gift'::character varying])::text[])),
    status_last varchar(255)
        constraint transfers_status_last_check
            check ((status_last)::text = ANY
                   ((ARRAY ['exchange'::character varying, 'transfer'::character varying, 'paid'::character varying, 'refund'::character varying, 'gift'::character varying])::text[])),
    deposit_id  bigint                                             not null
        constraint transfers_deposit_id_foreign
            references transactions
            on delete cascade,
    withdraw_id bigint                                             not null
        constraint transfers_withdraw_id_foreign
            references transactions
            on delete cascade,
    discount    numeric(64)  default '0'::numeric                  not null,
    fee         numeric(64)  default '0'::numeric                  not null,
    uuid        uuid                                               not null
        constraint transfers_uuid_unique
            unique,
    created_at  timestamp(0),
    updated_at  timestamp(0)
);

alter table transfers
    owner to noveladmin;

create index transfers_from_type_from_id_index
    on transfers (from_type, from_id);

create index transfers_to_type_to_id_index
    on transfers (to_type, to_id);

create index wallets_holder_type_holder_id_index
    on wallets (holder_type, holder_id);

create index wallets_slug_index
    on wallets (slug);

create table failed_jobs
(
    id         bigserial                              not null
        constraint failed_jobs_pkey
            primary key,
    uuid       varchar(255)                           not null
        constraint failed_jobs_uuid_unique
            unique,
    connection text                                   not null,
    queue      text                                   not null,
    payload    text                                   not null,
    exception  text                                   not null,
    failed_at  timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table failed_jobs
    owner to noveladmin;

create table personal_access_tokens
(
    id             bigserial    not null
        constraint personal_access_tokens_pkey
            primary key,
    tokenable_type varchar(255) not null,
    tokenable_id   bigint       not null,
    name           varchar(255) not null,
    token          varchar(64)  not null
        constraint personal_access_tokens_token_unique
            unique,
    abilities      text,
    last_used_at   timestamp(0),
    expires_at     timestamp(0),
    created_at     timestamp(0),
    updated_at     timestamp(0)
);

alter table personal_access_tokens
    owner to noveladmin;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

create table farms
(
    id                  bigserial    not null
        constraint farms_pkey
            primary key,
    user_id             bigint       not null,
    latitude            varchar(255) not null,
    longitude           varchar(255) not null,
    state_id            bigint       not null,
    local_government_id bigint       not null,
    ward_id             bigint       not null,
    address             varchar(255),
    landmark            varchar(255),
    size                integer      not null,
    unit                varchar(255) not null,
    status              varchar(255) not null
        constraint farms_status_check
            check ((status)::text = 'irrigation'::text),
    created_at          timestamp(0),
    updated_at          timestamp(0)
);

alter table farms
    owner to noveladmin;

create table farm_addresses
(
    id         bigserial not null
        constraint farm_addresses_pkey
            primary key,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table farm_addresses
    owner to noveladmin;

create table user_types
(
    id         bigserial             not null
        constraint user_types_pkey
            primary key,
    name       varchar(255)          not null,
    is_admin   boolean default false not null,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table user_types
    owner to noveladmin;

create table states
(
    id         bigserial    not null
        constraint states_pkey
            primary key,
    name       varchar(255) not null,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table states
    owner to noveladmin;

create table local_governments
(
    id         bigserial    not null
        constraint local_governments_pkey
            primary key,
    state_id   bigint       not null,
    name       varchar(255) not null,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table local_governments
    owner to noveladmin;

create table otps
(
    id                 bigserial             not null
        constraint otps_pkey
            primary key,
    identifier         varchar(255)          not null,
    token              varchar(255)          not null,
    key                varchar(255)          not null,
    validity           integer               not null,
    expired            boolean default false not null,
    no_times_generated integer default 0     not null,
    no_times_attempted integer default 0     not null,
    generated_at       timestamp(0)          not null,
    created_at         timestamp(0),
    updated_at         timestamp(0)
);

alter table otps
    owner to noveladmin;

create table wards
(
    id         bigserial    not null
        constraint wards_pkey
            primary key,
    lga_id     bigint       not null,
    name       varchar(255) not null,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table wards
    owner to noveladmin;


