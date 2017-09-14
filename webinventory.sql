-- This is a tracker to store login attempts
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Shop types
CREATE TABLE IF NOT EXISTS `shop_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
INSERT INTO `shop_type` (`id`, `type`) VALUES
(1, 'small'),
(2, 'medium');
-- shop info
CREATE TABLE IF NOT EXISTS `shop_info` (
	`id` int NOT NULL auto_increment,
	`name` varchar(200) NOT NULL default '',
	`address` varchar(500) NOT NULL default '',
	`shop_phone` varchar(200) NOT NULL default '',	
    `picture` varchar(500) default '',
	`created_on` int(11) unsigned DEFAULT 0,
	`modified_on` int(11) unsigned DEFAULT 0,
	`shop_type_id` int(11) DEFAULT NULL,
	`sale_default_purchase_order_no` varchar(500) default '',
	`purchase_default_purchase_order_no` varchar(500) default '',
	PRIMARY KEY  (`id`),
	KEY `shop_type_id` (`shop_type_id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `shop_info`
  ADD CONSTRAINT `shop_info_ibfk_1` FOREIGN KEY (`shop_type_id`) REFERENCES `shop_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `shop_info` (`id`, `name`, `shop_type_id`, `picture`) VALUES
(1, 'Arong', 1, 'shop.jpg');

-- user groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'manager', 'Manager'),
(3, 'salesman', 'Equipment Supplier'),
(4, 'supplier', 'Supplier'),
(5, 'customer', 'Customer'),
(6, 'staff', 'Staff');

-- User account status
CREATE TABLE IF NOT EXISTS `account_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;   
INSERT INTO `account_status` (`id`, `description`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'Suspended'),
(4, 'Deactivated'),
(5, 'Blocked');

-- users info
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  `last_login` int(11) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT '',
  `last_name` varchar(50) DEFAULT '',
  `phone` varchar(20) DEFAULT '',
  `address` varchar(500) DEFAULT '',
  `account_status_id` int NOT NULL,
  `sms_code` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_laccount_status1` FOREIGN KEY (`account_status_id`) REFERENCES `account_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(1, '', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Admin', 'istrator', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(2, '', 'manager', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'manager@manager.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Manager', 'Manager', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(3, '', 'salesman', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'salesman@salesman.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Salesman', 'Salesman', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(4, '', 'supplier', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'supplier@supplier.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Supplier', 'Supplier', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(5, '', 'customer', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'customer@customer.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Customer', 'Customer', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(6, '', 'staff', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'staff@staff.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Staff', 'Staff', '0');

-- Users and groups relationship
CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7;
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6);

-- Users and Shops relationship
CREATE TABLE IF NOT EXISTS `users_shop_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `shop_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`shop_id`),
  KEY `fk_users_shop_info_users1_idx` (`user_id`),
  KEY `fk_users_shop_info_shop_info1_idx` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `users_shop_info`
  ADD CONSTRAINT `fk_users_shop_info_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_shop_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `users_shop_info` (`id`, `user_id`, `shop_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1);

-- Supplier Info
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `company` varchar(200) DEFAULT NULL,  
  PRIMARY KEY (`id`),
  KEY `fk_suppliers_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `suppliers`
  ADD CONSTRAINT `fk_suppliers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 
-- Customer Info
CREATE TABLE IF NOT EXISTS `profession` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200) NOT NULL default '',
	`shop_id` int NOT NULL,
	`created_on` int(11) unsigned DEFAULT 0,
	`modified_on` int(11) unsigned DEFAULT 0,
	PRIMARY KEY  (`id`),
	KEY `fk_profession_shop_info1_idx` (`shop_id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `profession`
  ADD CONSTRAINT `fk_profession_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `profession` (`id`, `description`, `shop_id`) VALUES
(1, 'Other', 1),
(2, 'Profession1', 1),
(3, 'Profession2', 1),
(4, 'Profession3', 1),
(5, 'Profession4', 1),
(6, 'Profession5', 1);
CREATE TABLE IF NOT EXISTS `institution` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200) NOT NULL default '',
	`shop_id` int NOT NULL,	
	`created_on` int(11) unsigned DEFAULT 0,
	`modified_on` int(11) unsigned DEFAULT 0,
	PRIMARY KEY  (`id`),
	KEY `fk_institution_shop_info1_idx` (`shop_id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `institution`
  ADD CONSTRAINT `fk_institution_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `institution` (`id`, `description`, `shop_id`) VALUES
(1, 'Other', 1),
(2, 'Institution1', 1),
(3, 'Institution2', 1),
(4, 'Institution3', 1),
(5, 'Institution4', 1),
(6, 'Institution5', 1); 
 CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `card_no` varchar(200) DEFAULT NULL, 
  `institution_id` int DEFAULT NULL,
  `profession_id` int DEFAULT NULL, 
  PRIMARY KEY (`id`),
  KEY `fk_customers_users1_idx` (`user_id`),
  KEY `fk_customers_institution1_idx` (`institution_id`),
  KEY `fk_customers_profession1_idx` (`profession_id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customers_institution1` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customers_profession1` FOREIGN KEY (`profession_id`) REFERENCES `profession` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
-- Product info
CREATE TABLE IF NOT EXISTS `product_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `shop_id` int DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_product_sizes_shop_info1_idx` (`shop_id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `fk_product_sizes_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
insert into product_sizes (title, shop_id) values('1', 1);


CREATE TABLE IF NOT EXISTS `product_categories1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `shop_id` int DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_product_categories1_shop_info1_idx` (`shop_id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_categories1`
  ADD CONSTRAINT `fk_product_categories1_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
insert into product_categories1 (title, shop_id) values('1', 1);


CREATE TABLE IF NOT EXISTS `product_unit_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL DEFAULT '',
  `shop_id` int(11) NOT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_product_unit_category_shop_info1_idx` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_unit_category`
  ADD CONSTRAINT `fk_product_unit_category_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `product_unit_category` (`description`, `shop_id`) VALUES
('piece', 1), 
('liter', 1); 
 CREATE TABLE IF NOT EXISTS `product_info` (
	`id` int NOT NULL auto_increment,
	`name` varchar(200) NOT NULL,
	`serial_no` int DEFAULT 0,
	`code` varchar(200)  DEFAULT '',
	`size` varchar(200) DEFAULT '',
	`weight` varchar(200) DEFAULT '',
	`warranty` varchar(200) DEFAULT '',
	`quality` varchar(200) DEFAULT '',
	`unit_price` double default 0,
	`brand_name` varchar(200) DEFAULT '',
	`remarks` varchar(1000) DEFAULT '',
	`shop_id` int DEFAULT NULL,
	`unit_category_id` int DEFAULT NULL,
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_product_info_shop_info1_idx` (`shop_id`),
	KEY `fk_product_info_product_unit_category1_idx` (`unit_category_id`),
	KEY `fk_product_info_users1_idx` (`created_by`),
	KEY `fk_product_info_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_info`
  ADD CONSTRAINT `fk_product_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_info_product_unit_category1` FOREIGN KEY (`unit_category_id`) REFERENCES `product_unit_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_info_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `product_info` (`id`, `serial_no`, `name`, `shop_id`, `unit_category_id`) VALUES
(1, 1,'Product1', 1, 1),
(2, 2,'Product2', 1, 1),
(3, 3,'Product3', 1, 1),
(4, 4,'Product4', 1, 1),
(5, 5,'Product5', 1, 1),
(6, 6,'Product6', 1, 1),
(7, 7,'Product7', 1, 1),
(8, 8,'Product8', 1, 1),
(9, 9,'Product9', 1, 1),
(10, 10,'Product10', 1, 1);
-- this table is not required actually. We will add a json object to store image list in product info table 
 CREATE TABLE IF NOT EXISTS `product_image_info` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,
	`image_name` varchar(500),
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_product_image_info_product_info1_idx` (`product_id`),
	KEY `fk_product_image_info_users1_idx` (`created_by`),
	KEY `fk_product_image_info_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_image_info`
  ADD CONSTRAINT `fk_product_image_info_product_info1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_image_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_image_info_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE; 

-- warehouse purchase info
CREATE TABLE IF NOT EXISTS `purchase_order_status` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200),	
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `purchase_order_status` (`id`, `description`) VALUES
(1, 'Open'),
(2, 'In Progress'),
(3, 'Fully Received'),
(4, 'Paid'),
(5, 'Cancelled');
CREATE TABLE IF NOT EXISTS `purchase_order` (	
	`id` int NOT NULL auto_increment,
	`purchase_order_no` varchar(200),
	`product_category1` varchar(200) DEFAULT '',
	`product_size` varchar(200) DEFAULT '',
	`shop_id` int NOT NULL,
	`supplier_id` int NOT NULL,
	`purchase_order_status_id` int NOT NULL,
	`order_date` int(11) unsigned DEFAULT 0,
	`requested_ship_date` int(11) unsigned DEFAULT 0,	
	`discount` double default 0,
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	`remarks` varchar(500),
	PRIMARY KEY  (`id`),
	UNIQUE KEY (`purchase_order_no`, `shop_id`),
	KEY `fk_purchase_order_shop_info1_idx` (`shop_id`),
	KEY `fk_purchase_order_purchase_order_status1_idx` (`purchase_order_status_id`),
	KEY `fk_purchase_order_suppliers1_idx` (`supplier_id`),
	KEY `fk_purchase_order_users1_idx` (`created_by`),
	KEY `fk_purchase_order_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `fk_purchase_order_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_order_purchase_order_status1` FOREIGN KEY (`purchase_order_status_id`) REFERENCES `purchase_order_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_order_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_order_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_order_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `warehouse_product_purchase_order` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,	
	`purchase_order_no` varchar(200),
	`product_category1` varchar(200) DEFAULT '',
	`product_size` varchar(200) DEFAULT '',
	`shop_id` int NOT NULL,
	`unit_price` double default 0,
	`discount` double default 0,
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_wppo_purchase_order1_idx` (`purchase_order_no`),
	KEY `fk_wppo_shop_info1_idx` (`shop_id`),
	KEY `fk_wppo_users1_idx` (`created_by`),
	KEY `fk_wppo_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `warehouse_product_purchase_order`
  ADD CONSTRAINT `fk_wppo_purchase_order1` FOREIGN KEY (`purchase_order_no`) REFERENCES `purchase_order` (`purchase_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wppo_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wppo_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wppo_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `warehouse_stock_transaction_category` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200),	
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `warehouse_stock_transaction_category` (`id`, `description`) VALUES
(1, 'Purchase In'),
(2, 'Purchase Partial In'),
(3, 'Purchase partial Out'),
(4, 'Purchase Delete'),
(5, 'Purchase Partial In From Showroom'),
(6, 'Purchase Partial Out To Showroom'); 
 CREATE TABLE IF NOT EXISTS `warehouse_stock_info` (
	`id` int NOT NULL auto_increment,
	`shop_id` int NOT NULL,
	`purchase_order_no` varchar(200) DEFAULT NULL,
	`product_category1` varchar(200) DEFAULT '',
	`product_size` varchar(200) DEFAULT '',
	`product_id` int NOT NULL,
	`stock_in` double default 0,
	`stock_out` double default 0,
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	`transaction_category_id` int NOT NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_wsi_shop_info1_idx` (`shop_id`),
	KEY `fk_wsi_purchase_order1_idx` (`purchase_order_no`),
	KEY `fk_wsi_product_info1_idx` (`product_id`),
	KEY `fk_wsi_users1_idx` (`created_by`),
	KEY `fk_wsi_users2_idx` (`modified_by`),
	KEY `fk_wsi_wstcat1_idx` (`transaction_category_id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `warehouse_stock_info`
  ADD CONSTRAINT `fk_wsi_purchase_order1` FOREIGN KEY (`purchase_order_no`) REFERENCES `purchase_order` (`purchase_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wsi_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wsi_product_info1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wsi_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wsi_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wsi_wstcat1` FOREIGN KEY (`transaction_category_id`) REFERENCES `warehouse_stock_transaction_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- showroom sale
CREATE TABLE IF NOT EXISTS `sale_order_status` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200),	
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `sale_order_status` (`id`, `description`) VALUES
(1, 'Quote'),
(2, 'Open'),
(3, 'In Progress'),
(4, 'Fully Shipped'),
(5, 'Invoiced'),
(6, 'Paid'),
(7, 'Cancelled');
CREATE TABLE IF NOT EXISTS `sale_order` (
	`id` int NOT NULL auto_increment,
	`sale_order_no` varchar(200),
	`shop_id` int NOT NULL,
	`customer_id` int NOT NULL,
	`sale_order_status_id` int NOT NULL,
	`sale_date` int(11) unsigned DEFAULT NULL,
	`discount` double default 0,
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int NOT NULL,
	`entry_by` int DEFAULT 1,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	`remarks` varchar(500),
	PRIMARY KEY  (`id`),
	UNIQUE KEY (`sale_order_no`, `shop_id`),
	KEY `fk_sale_order_shop_info1_idx` (`shop_id`),
	KEY `fk_sale_order_sale_order_status1_idx` (`sale_order_status_id`),
	KEY `fk_sale_order_customers1_idx` (`customer_id`),
	KEY `fk_sale_order_users1_idx` (`created_by`),
	KEY `fk_sale_order_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `sale_order`
  ADD CONSTRAINT `fk_sale_order_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_order_sale_order_status1` FOREIGN KEY (`sale_order_status_id`) REFERENCES `sale_order_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_order_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_order_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_order_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `product_sale_order` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,	
	`sale_order_no` varchar(200),
	`shop_id` int NOT NULL,
	`purchase_order_no` varchar(200),
	`product_category1` varchar(200) DEFAULT '',
	`product_size` varchar(200) DEFAULT '',
	`unit_price` double default 0,
	`discount` double default 0,
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int NOT NULL,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_product_sale_order_sale_order1_idx` (`sale_order_no`),
	KEY `fk_product_sale_order_purchase_order1_idx` (`purchase_order_no`),
	KEY `fk_product_sale_order_shop_info1_idx` (`shop_id`),
	KEY `fk_product_sale_order_users1_idx` (`created_by`),
	KEY `fk_product_sale_order_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_sale_order`
  ADD CONSTRAINT `fk_product_sale_order_sale_order1` FOREIGN KEY (`sale_order_no`) REFERENCES `sale_order` (`sale_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_sale_order_purchase_order1` FOREIGN KEY (`purchase_order_no`) REFERENCES `purchase_order` (`purchase_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_sale_order_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_sale_order_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_sale_order_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
    
-- showroom purchase info
CREATE TABLE IF NOT EXISTS `product_purchase_order` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,	
	`purchase_order_no` varchar(200),
	`product_category1` varchar(200) DEFAULT '',
	`product_size` varchar(200) DEFAULT '',
	`shop_id` int NOT NULL,
	`unit_price` double default 0,
	`discount` double default 0,
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_product_purchase_order_purchase_order1_idx` (`purchase_order_no`),
	KEY `fk_product_purchase_order_shop_info1_idx` (`shop_id`),
	KEY `fk_product_purchase_order_users1_idx` (`created_by`),
	KEY `fk_product_purchase_order_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_purchase_order`
  ADD CONSTRAINT `fk_product_purchase_order_purchase_order1` FOREIGN KEY (`purchase_order_no`) REFERENCES `purchase_order` (`purchase_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_purchase_order_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_purchase_order_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_purchase_order_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE; 
 
CREATE TABLE IF NOT EXISTS `stock_transaction_category` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200),	
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `stock_transaction_category` (`id`, `description`) VALUES
(1, 'Purchase In'),
(2, 'Purchase Partial In'),
(3, 'Purchase partial Out'),
(4, 'Purchase Delete'),
(5, 'Sale In'),
(6, 'Sale partial Out'),
(7, 'Sale Delete'); 
 CREATE TABLE IF NOT EXISTS `stock_info` (
	`id` int NOT NULL auto_increment,
	`shop_id` int NOT NULL,
	`purchase_order_no` varchar(200) DEFAULT NULL,
	`product_category1` varchar(200) DEFAULT '',
	`product_size` varchar(200) DEFAULT '',
	`sale_order_no` varchar(200) DEFAULT NULL,
	`product_id` int NOT NULL,
	`stock_in` double default 0,
	`stock_out` double default 0,
	`created_on` int(11) unsigned DEFAULT 0,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT 0,
    `modified_by` int default NULL,
	`transaction_category_id` int NOT NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_si_shop_info1_idx` (`shop_id`),
	KEY `fk_si_purchase_order1_idx` (`purchase_order_no`),
	KEY `fk_si_sale_order1_idx` (`sale_order_no`),
	KEY `fk_si_product_info1_idx` (`product_id`),
	KEY `fk_si_users1_idx` (`created_by`),
	KEY `fk_si_users2_idx` (`modified_by`),
	KEY `fk_si_stock_transaction_category1_idx` (`transaction_category_id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `stock_info`
  ADD CONSTRAINT `fk_si_purchase_order1` FOREIGN KEY (`purchase_order_no`) REFERENCES `purchase_order` (`purchase_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_si_sale_order1` FOREIGN KEY (`sale_order_no`) REFERENCES `sale_order` (`sale_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_si_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_si_product_info1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_si_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_si_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_si_stock_transaction_category1` FOREIGN KEY (`transaction_category_id`) REFERENCES `stock_transaction_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Expense Module 
CREATE TABLE IF NOT EXISTS `expense_type` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200),	
	`order` int,	
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `expense_type` (`id`, `description`, `order`) VALUES
(1, 'Shop', 1),
(2, 'Supplier', 2),
(3, 'Equipment Supplier', 3),
(4, 'Other', 5), 
(5, 'Staff', 4);  
CREATE TABLE IF NOT EXISTS `expense_info` (
	`id` int NOT NULL AUTO_INCREMENT,
	`shop_id` int NOT NULL,
	`expense_type_id` int NOT NULL,
	`reference_id` int DEFAULT 0,
	`description` varchar(200) NOT NULL,
	`expense_amount` double DEFAULT 0,
	`expense_date` int(11) unsigned DEFAULT NULL,
	`created_on` int(11) unsigned DEFAULT 0,
	`created_by` int,
	`modified_on` int(11) unsigned DEFAULT 0,
	`modified_by` int default NULL,
	PRIMARY KEY (`id`),
	KEY `fk_expense_info_shop_info1_idx` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `expense_info`
  ADD CONSTRAINT `fk_expense_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expense_info_expense_type1` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
-- -----------------------------------SMS module --------------
CREATE TABLE IF NOT EXISTS `sms_configuration_shop` (
  `shop_id` int NOT NULL,
  `status` boolean default FALSE,
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;  
ALTER TABLE `sms_configuration_shop`
  ADD CONSTRAINT `fk_sms_configuration_shop_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
CREATE TABLE IF NOT EXISTS `operators` (
  `operator_prefix` varchar(50) NOT NULL,	
  `operator_name` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`operator_prefix`, `operator_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;  

-- ---------------------------------Supplier payment record ---------------------------
CREATE TABLE IF NOT EXISTS `supplier_payment_category_info` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200) NOT NULL default '',
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `supplier_payment_category_info` (`id`, `description`) VALUES
(1, 'Purchase Payment'),
(2, 'Expense Payment');
CREATE TABLE IF NOT EXISTS `supplier_payment_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `amount` double default 0,
  `payment_category_id` int NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `reference_id` varchar(200) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_supplier_payment_info_shop_info1_idx` (`shop_id`),
  KEY `fk_supplier_payment_info_suppliers1_idx` (`supplier_id`),
  KEY `fk_supplier_payment_info_supplier_payment_category_info1_idx` (`payment_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `supplier_payment_info`
  ADD CONSTRAINT `fk_supplier_payment_info_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supplier_payment_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supplier_payment_info_supplier_payment_category_info1` FOREIGN KEY (`payment_category_id`) REFERENCES `supplier_payment_category_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `supplier_returned_payment_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `purchase_order_no` varchar(200),
  `amount` double default 0,
  `description` varchar(200) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `created_by` int,
  PRIMARY KEY (`id`),
  KEY `fk_supplier_returned_payment_info_shop_info1_idx` (`shop_id`),
  KEY `fk_supplier_returned_payment_info_suppliers1_idx` (`supplier_id`),
  KEY `fk_supplier_returned_payment_info_users1_idx` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `supplier_returned_payment_info`
	ADD CONSTRAINT `fk_supplier_returned_payment_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_supplier_returned_payment_info_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_supplier_returned_payment_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
CREATE TABLE IF NOT EXISTS `supplier_transaction_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `lot_no` varchar(200) DEFAULT '',
  `product_category1` varchar(200) DEFAULT '',
  `product_size` varchar(200) DEFAULT '',
  `name` varchar(200) DEFAULT '', 
  `quantity` varchar(200) DEFAULT '',
  `unit_price` varchar(200) DEFAULT '',
  `sub_total` varchar(200) DEFAULT '',
  `payment_status` varchar(200) DEFAULT '',
  `remarks` varchar(500),
  PRIMARY KEY (`id`),
  KEY `fk_supplier_transaction_info_shop_info1_idx` (`shop_id`),
  KEY `fk_supplier_transaction_info_suppliers1_idx` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `supplier_transaction_info`
  ADD CONSTRAINT `fk_supplier_transaction_info_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supplier_transaction_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 

-- --------------------------------Customer payment record ---------------------------
CREATE TABLE IF NOT EXISTS `customer_payment_type_info` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200) NOT NULL default '',
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `customer_payment_type_info` (`id`, `description`) VALUES
(1, 'Cash'),
(2, 'Check');
CREATE TABLE IF NOT EXISTS `customer_payment_category_info` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200) NOT NULL default '',
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `customer_payment_category_info` (`id`, `description`) VALUES
(1, 'Sale Payment'),
(2, 'Due Collect');
CREATE TABLE IF NOT EXISTS `customer_payment_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `sale_order_no` varchar(200),
  `customer_id` int NOT NULL,
  `amount` double default 0,
  `payment_type_id` int NOT NULL,
  `payment_category_id` int NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `reference_id` varchar(200) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_customer_payment_info_shop_info1_idx` (`shop_id`),
  KEY `fk_customer_payment_info_customers1_idx` (`customer_id`),
  KEY `fk_customer_payment_info_customer_payment_type_info1_idx` (`payment_type_id`),
  KEY `fk_customer_payment_info_customer_payment_category_info1_idx` (`payment_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `customer_payment_info`
  ADD CONSTRAINT `fk_customer_payment_info_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_payment_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_payment_info_customer_payment_type_info1` FOREIGN KEY (`payment_type_id`) REFERENCES `customer_payment_type_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_payment_info_customer_payment_category_info1` FOREIGN KEY (`payment_category_id`) REFERENCES `customer_payment_category_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

 CREATE TABLE IF NOT EXISTS `customer_returned_payment_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `sale_order_no` varchar(200),
  `customer_id` int NOT NULL,
  `amount` double default 0,
  `description` varchar(200) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `created_by` int,
  PRIMARY KEY (`id`),
  KEY `fk_customer_returned_payment_info_shop_info1_idx` (`shop_id`),
  KEY `fk_customer_returned_payment_info_customers1_idx` (`customer_id`),
  KEY `fk_customer_returned_payment_info_users1_idx` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `customer_returned_payment_info`
  ADD CONSTRAINT `fk_customer_returned_payment_info_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_returned_payment_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_returned_payment_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

  
CREATE TABLE IF NOT EXISTS `customer_transaction_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `sale_order_no` varchar(200),
  `customer_id` int NOT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `lot_no` varchar(200) DEFAULT '',
  `product_category1` varchar(200) DEFAULT '',
  `product_size` varchar(200) DEFAULT '',
  `name` varchar(200) DEFAULT '', 
  `quantity` varchar(200) DEFAULT '',
  `unit_price` varchar(200) DEFAULT '',
  `sub_total` varchar(200) DEFAULT '',
  `payment_status` varchar(200) DEFAULT '',
  `profit` varchar(200) DEFAULT '',
  `remarks` varchar(500),
  PRIMARY KEY (`id`),
  KEY `fk_customer_transaction_info_shop_info1_idx` (`shop_id`),
  KEY `fk_customer_transaction_info_customers1_idx` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `customer_transaction_info`
  ADD CONSTRAINT `fk_customer_transaction_info_info_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_transaction_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 
-- -------------------------------Attendance ---------------------------------------- 
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `user_id` int NOT NULL,
  `login_date` varchar(200) DEFAULT '',
  `login_time` varchar(200) DEFAULT '',
  `logout_time` varchar(200) DEFAULT '',
  `attendance_comment` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_attendance_shop_info1_idx` (`shop_id`),
  KEY `fk_attendance_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attendance_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- ------------------------------ Configuring messages ---------------------------------  
CREATE TABLE IF NOT EXISTS `message_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL DEFAULT '',
  `shop_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `message_category`
  ADD CONSTRAINT `fk_message_category_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `message_category` (`id`, `description`, `shop_id`, `type_id`) VALUES
(1, 'Customer registration', 1, 1),
(2, 'Supplier registration', 1, 2);

CREATE TABLE IF NOT EXISTS `message_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_description` varchar(200) NOT NULL DEFAULT '',
  `message_category_id` int(11) DEFAULT NULL,
  `shop_id` int(11) NOT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `message_info`
  ADD CONSTRAINT `fk_message_info_message_category1` FOREIGN KEY (`message_category_id`) REFERENCES `message_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `message_info` (`id`, `message_description`, `message_category_id`, `shop_id`) VALUES
(1, 'Congratulation for successfully registration for lifetime discount card. thanks, APURBO brand Bangladesh. Chandrima market, New market', 1, 1),
(2, 'We hope that we can establish a good business relationship with you. Thanks, APURBO brand Bangladesh. Chandrima market, New market', 2, 1);
--
-- Table structure for table `supplier_message`
--

CREATE TABLE IF NOT EXISTS `supplier_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(200) NOT NULL DEFAULT '',
  `supplier_id` int(11) NOT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_supplier_message_suppliers1_idx` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `supplier_message`
  ADD CONSTRAINT `fk_supplier_message_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Message feature created, modified and used by admin  
CREATE TABLE IF NOT EXISTS `custom_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `message` varchar(5000) NOT NULL DEFAULT '',
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `custom_message`
  ADD CONSTRAINT `fk_custom_message_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- sms processing andorid app
CREATE TABLE IF NOT EXISTS `phone_directory`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `phone_number` varchar(100),
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY(`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `phone_upload_list`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `number_list` text,
  `global_msg` varchar(1000) DEFAULT '',
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY(`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `queue_table` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone_upload_list_id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `unprocess_list` text,
  `is_processing` boolean DEFAULT FALSE,
  `success_list` text,
  `failed_list` text,
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `queue_table`
  ADD CONSTRAINT `fk_queue_table1` FOREIGN KEY (`phone_upload_list_id`) REFERENCES `phone_upload_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


