-- drop database web_inventory;
-- create database web_inventory;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `shop_info` (
	`id` int NOT NULL auto_increment,
	`shop_no` varchar(200) NOT NULL default '',	
	`name` varchar(200) NOT NULL default '',
	`address` varchar(500) NOT NULL default '',
	`shop_phone` varchar(200) NOT NULL default '',	
    `picture` varchar(500) default '',
	`created_date` timestamp,
	`modified_date` timestamp,
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'manager', 'Manager'),
(3, 'salesman', 'Salesman'),
(4, 'supplier', 'Supplier'),
(5, 'customer', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

--
-- Table structure for table `users`
--

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
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `account_status_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_laccount_status1` FOREIGN KEY (`account_status_id`) REFERENCES `account_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Admin', 'istrator', 'ADMIN', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `company`, `phone`) VALUES
(2, '\0\0', 'manager', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'manager@manager.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Manager', 'Manager', 'Manager', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `company`, `phone`) VALUES
(3, '\0\0', 'salesman', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'salesman@salesman.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Salesman', 'Salesman', 'Salesman', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `company`, `phone`) VALUES
(4, '\0\0', 'supplier', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'supplier@supplier.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Supplier', 'Supplier', 'Supplier', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `company`, `phone`) VALUES
(5, '\0\0', 'customer', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'customer@customer.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Customer', 'Customer', 'Customer', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

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
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 3, 3),
(5, 4, 4),
(6, 5, 5);


 CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendors_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `vendors`
  ADD CONSTRAINT `fk_vendors_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
 CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customers_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
 CREATE TABLE `product_info` (
	`id` int NOT NULL auto_increment,
	`product_name` varchar(200),
	`product_size` varchar(200),
	`product_weight` varchar(200),
	`product_warranty` varchar(200),
	`product_quality` varchar(200),
	`unit_price` double,
	`brand_name` varchar(200),
	`remarks` varchar(1000),
	`created_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `created_by` int,
    `modified_date` timestamp,
    `modified_by` int,
	PRIMARY KEY  (`id`),
	KEY `fk_product_info_users1_idx` (`created_by`),
	KEY `fk_product_info_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_info`
  ADD CONSTRAINT `fk_product_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_info_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 
 CREATE TABLE `product_image_info` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,
	`product_size` varchar(200),
	`image_path` varchar(500),
	`created_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `created_by` int,
    `modified_date` timestamp,
    `modified_by` int,
	PRIMARY KEY  (`id`),
	KEY `fk_product_image_info_product_info1_idx` (`product_id`),
	KEY `fk_product_image_info_users1_idx` (`created_by`),
	KEY `fk_product_image_info_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_image_info`
  ADD CONSTRAINT `fk_product_image_info_product_info1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_image_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_image_info_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE; 
 
 CREATE TABLE `stock_info` (
	`id` int NOT NULL auto_increment,
	`shop_id` int NOT NULL,
	`product_id` int NOT NULL,
	`stock_amount` double,
	`created_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `created_by` int,
    `modified_date` timestamp,
    `modified_by` int,
	PRIMARY KEY  (`id`),
	KEY `fk_stock_info_shop_info1_idx` (`shop_id`),
	KEY `fk_stock_info_product_info1_idx` (`product_id`),
	KEY `fk_stock_info_users1_idx` (`created_by`),
	KEY `fk_stock_info_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `stock_info`
  ADD CONSTRAINT `fk_stock_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_info_product_info1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_info_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 
CREATE TABLE `purchase_order_status` (
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

CREATE TABLE `purchase_order` (
	`id` int NOT NULL auto_increment,
	`purchase_order_no` varchar(200),
	`shop_id` int NOT NULL,
	`vendor_id` int NOT NULL,
	`purchase_order_status_id` int NOT NULL,
	`order_date` timestamp,
	`requested_ship_date` timestamp,	
	`discount` varchar(200),
	`total` double,
	`paid` double,
	`created_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `created_by` int,
    `modified_date` timestamp,
    `modified_by` int default 0,
	`remarks` varchar(500),
	PRIMARY KEY  (`id`),
	KEY `fk_purchase_order_shop_info1_idx` (`shop_id`),
	KEY `fk_purchase_order_purchase_order_status1_idx` (`purchase_order_status_id`),
	KEY `fk_purchase_order_vendors1_idx` (`vendor_id`),
	KEY `fk_purchase_order_users1_idx` (`created_by`),
	KEY `fk_purchase_order_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `fk_purchase_order_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_order_purchase_order_status1` FOREIGN KEY (`purchase_order_status_id`) REFERENCES `purchase_order_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_order_vendors1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_order_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_order_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
CREATE TABLE `product_purchase_order` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,	
	`purchase_order_id` int NOT NULL,
	`quantity` double,
	`unit_price` double,
	`discount` varchar(200),
	`sub_total` double,
	`created_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `created_by` int,
    `modified_date` timestamp,
    `modified_by` int default 0,
	PRIMARY KEY  (`id`),
	KEY `fk_product_purchase_order_purchase_order1_idx` (`purchase_order_id`),
	KEY `fk_product_purchase_order_users1_idx` (`created_by`),
	KEY `fk_product_purchase_order_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_purchase_order`
  ADD CONSTRAINT `fk_product_purchase_order_purchase_order1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_purchase_order_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_purchase_order_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
CREATE TABLE `sale_order_status` (
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
CREATE TABLE `sale_order` (
	`id` int NOT NULL auto_increment,
	`sale_order_no` varchar(200),
	`shop_id` int NOT NULL,
	`customer_id` int NOT NULL,
	`sale_order_status_id` int NOT NULL,
	`sale_date` timestamp,
	`discount` varchar(200),
	`total` double,
	`paid` double,
	`created_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `created_by` int,
    `modified_date` timestamp,
    `modified_by` int default 0,
	`remarks` varchar(500),
	PRIMARY KEY  (`id`),
	KEY `fk_sale_order_shop_info1_idx` (`shop_id`),
	KEY `fk_sale_order_sale_order_status1_idx` (`sale_order_status_id`),
	KEY `fk_sale_order_customers1_idx` (`customer_id`),
	KEY `fk_sale_order_users1_idx` (`created_by`),
	KEY `fk_sale_order_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `sale_order`
  ADD CONSTRAINT `fk_sale_order_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_order_sale_order_status1` FOREIGN KEY (`sale_order_status_id`) REFERENCES `sale_order_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_order_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customrts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_order_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_order_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
CREATE TABLE `product_sale_order` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,	
	`sale_order_id` int NOT NULL,
	`quantity` double,
	`unit_price` double,
	`discount` varchar(200),
	`sub_total` double,
	`created_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `created_by` int,
    `modified_date` timestamp,
    `modified_by` int default 0,
	PRIMARY KEY  (`id`),
	KEY `fk_product_sale_order_sale_order1_idx` (`sale_order_id`),
	KEY `fk_product_sale_order_users1_idx` (`created_by`),
	KEY `fk_product_sale_order_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_sale_order`
  ADD CONSTRAINT `fk_product_sale_order_sale_order1` FOREIGN KEY (`sale_order_id`) REFERENCES `sale_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_sale_order_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_sale_order_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;