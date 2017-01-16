CREATE TABLE bitcoin_payment(
	id integer unsigned AUTO_INCREMENT PRIMARY KEY NOT NULL,
	datetime DATETIME not null,
	address varchar(100) not null,
	total float not null,
	used boolean not null default 0,
	confirmation_amount tinyint unsigned not null default 0,
    transaction_hash varchar(255) not null DEFAULT '',
	INDEX (address)
);

ALTER TABLE bitcoin_payment ADD confirmation_amount tinyint unsigned not null default 0;
ALTER TABLE bitcoin_payment ADD transaction_hash varchar(255) not null DEFAULT '';
ALTER TABLE bitcoin_payment ADD user_id integer unsigned NOT NULL;

CREATE TABLE bitcoin_address(
	id integer unsigned AUTO_INCREMENT PRIMARY KEY NOT NULL,
	address varchar(100) not null,
	user_id integer unsigned NOT NULL
);