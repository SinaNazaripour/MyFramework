CREATE TABLE IF NOT EXISTS users(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT ,
    email varchar(100) NOT NULL ,
    password varchar(100) NOT NULL,
    age tinyint(2) unsigned NOT NULL,
    country varchar(100) NOT NULL ,
    social_media_url varchar(100) NOT NULL ,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY(id),
    UNIQUE Key (email)
);

CREATE TABLE IF NOT EXISTS transactions (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    amount decimal(8,2) unsigned NOT NULL,
    description varchar(255) NOT NULL,
    date datetime NOT NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    user_id bigint(20) unsigned NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS receipts (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    original_filename varchar(50) NOT NULL,
    storage_filename varchar(40) NOT NULL,
    media_type varchar(20) NOT NULL,
    transaction_id bigint(20) unsigned NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(transaction_id) REFERENCES transactions(id) ON DELETE CASCADE
);