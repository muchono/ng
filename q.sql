ALTER TABLE  order_to_product 
ADD url_res varchar(500) not null default '';

ALTER TABLE `order` ADD notif_frequency smallint unsigned not null default 1;