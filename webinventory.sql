-- drop database web_inventory;
-- create database web_inventory;
-- use web_inventory;

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

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
INSERT INTO `shop_info` (`id`, `shop_no`, `name`) VALUES
(1, 1, 'Apurbo');

CREATE TABLE `profession` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200) NOT NULL default '',
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `profession` (`id`, `description`) VALUES
(1, 'Business'),
(2, 'Doctor'),
(3, 'Engineer'),
(4, 'Lawyear'),
(5, 'Service'),
(6, 'Student'),
(7, 'Other');

CREATE TABLE `institution` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200) NOT NULL default '',
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `institution` (`id`, `description`) VALUES
(1, 'BUET'),
(2, 'Dhaka College'),
(3, 'Dhaka City College'),
(4, 'Dhaka Medical College'),
(5, 'Dhaka University'),
(6, 'Jagonnath University'),
(7, 'Jahangirnagar University'),
(8, 'Mirpur Bangla College');



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
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(500) DEFAULT '',
  `account_status_id` int NOT NULL,
  `created_date` timestamp,
  `modified_date` timestamp,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_laccount_status1` FOREIGN KEY (`account_status_id`) REFERENCES `account_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Admin', 'istrator', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(2, '\0\0', 'manager', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'manager@manager.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Manager', 'Manager', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(3, '\0\0', 'salesman', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'salesman@salesman.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Salesman', 'Salesman', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(4, '\0\0', 'supplier', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'supplier@supplier.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Supplier', 'Supplier', '0');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `account_status_id`, `first_name`, `last_name`, `phone`) VALUES
(5, '\0\0', 'customer', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'customer@customer.com', '', NULL, NULL, NULL, 1268889823, 1373438882, 1, 'Customer', 'Customer', '0');

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
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

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
(5, 5, 1);

 CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `company` varchar(200) DEFAULT NULL,  
  PRIMARY KEY (`id`),
  KEY `fk_suppliers_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `suppliers`
  ADD CONSTRAINT `fk_suppliers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
 CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `shop_id` int NOT NULL,
  `card_no` varchar(200) DEFAULT NULL, 
  `institution_id` int DEFAULT NULL,
  `profession_id` int DEFAULT NULL, 
  PRIMARY KEY (`id`),
  UNIQUE KEY (`shop_id`, `card_no`),
  KEY `fk_customers_users1_idx` (`user_id`),
  KEY `fk_customers_shop_info1_idx` (`shop_id`),
  KEY `fk_customers_institution1_idx` (`institution_id`),
  KEY `fk_customers_profession1_idx` (`profession_id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customers_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customers_institution1` FOREIGN KEY (`institution_id`) REFERENCES `institution` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customers_profession1` FOREIGN KEY (`profession_id`) REFERENCES `profession` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
 CREATE TABLE `product_info` (
	`id` int NOT NULL auto_increment,
	`name` varchar(200) NOT NULL,
	`code` varchar(200)  DEFAULT '',
	`size` varchar(200) DEFAULT '',
	`weight` varchar(200) DEFAULT '',
	`warranty` varchar(200) DEFAULT '',
	`quality` varchar(200) DEFAULT '',
	`unit_price` double default 0,
	`brand_name` varchar(200) DEFAULT '',
	`remarks` varchar(1000) DEFAULT '',
	`shop_id` int DEFAULT NULL,
	`created_date` timestamp,
    `created_by` int,
    `modified_date` timestamp,
    `modified_by` int default NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_product_info_shop_info1_idx` (`modified_by`),
	KEY `fk_product_info_users1_idx` (`created_by`),
	KEY `fk_product_info_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `product_info`
  ADD CONSTRAINT `fk_product_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_info_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 
 CREATE TABLE `product_image_info` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,
	`image_path` varchar(500),
	`created_date` timestamp,
    `created_by` int,
    `modified_date` timestamp,
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
	`supplier_id` int NOT NULL,
	`purchase_order_status_id` int NOT NULL,
	`order_date` timestamp,
	`requested_ship_date` timestamp,	
	`discount` double default 0,
	`total` double,
	`paid` double default 0,
	`created_on` int(11) unsigned DEFAULT NULL,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT NULL,
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
  
CREATE TABLE `product_purchase_order` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,	
	`purchase_order_no` varchar(200),
	`shop_id` int NOT NULL,
	`quantity` double,
	`unit_price` double,
	`discount` varchar(200) default 0,
	`sub_total` double,
	`created_on` int(11) unsigned DEFAULT NULL,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT NULL,
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
  
 CREATE TABLE `stock_info` (
	`id` int NOT NULL auto_increment,
	`shop_id` int NOT NULL,
	`supplier_id` int NOT NULL,
	`purchase_order_no` varchar(200),
	`product_id` int NOT NULL,
	`stock_amount` double,
	`created_on` int(11) unsigned DEFAULT NULL,
    `created_by` int,
    `modified_on` int(11) unsigned DEFAULT NULL,
    `modified_by` int default NULL,
	PRIMARY KEY  (`id`),
	KEY `fk_stock_info_shop_info1_idx` (`shop_id`),
	KEY `fk_stock_info_purchase_order1_idx` (`purchase_order_no`),
	KEY `fk_stock_info_product_info1_idx` (`product_id`),
	KEY `fk_stock_info_suppliers1_idx` (`supplier_id`),
	KEY `fk_stock_info_users1_idx` (`created_by`),
	KEY `fk_stock_info_users2_idx` (`modified_by`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `stock_info`
  ADD CONSTRAINT `fk_stock_info_purchase_order1` FOREIGN KEY (`purchase_order_no`) REFERENCES `purchase_order` (`purchase_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_info_product_info1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_info_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_info_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_info_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
  
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
	`discount` varchar(200) DEFAULT 0,
	`total` double,
	`paid` double,
	`created_date` timestamp,
    `created_by` int NOT NULL,
    `modified_date` timestamp,
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
  
CREATE TABLE `product_sale_order` (
	`id` int NOT NULL auto_increment,
	`product_id` int NOT NULL,	
	`sale_order_no` varchar(200),
	`shop_id` int NOT NULL,
	`purchase_order_no` varchar(200),
	`quantity` double,
	`unit_price` double,
	`discount` varchar(200) DEFAULT 0,
	`sub_total` double,
	`created_date` timestamp,
    `created_by` int NOT NULL,
    `modified_date` timestamp,
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
  
CREATE TABLE `expense_type` (
	`id` int NOT NULL auto_increment,
	`description` varchar(200),	
	PRIMARY KEY  (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `expense_type` (`id`, `description`) VALUES
(1, 'Shop'),
(2, 'Supplier'),
(3, 'User'),
(4, 'Other');  
CREATE TABLE IF NOT EXISTS `expense_info` (
	`id` int NOT NULL AUTO_INCREMENT,
	`expense_type_id` int NOT NULL,
	`reference_id` int DEFAULT 0,
	`description` varchar(200) NOT NULL,
	`expense_amount` double DEFAULT 0,
	`created_date` timestamp,
	`created_by` int,
	`modified_date` timestamp,
	`modified_by` int default NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `expense_info`
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
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`operator_prefix`, `operator_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;  

-- ---------------------------------Supplier payment record ---------------------------
CREATE TABLE IF NOT EXISTS `supplier_payment_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `amount` double default 0,
  `description` varchar(200) DEFAULT NULL,
  `reference_id` varchar(200) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_supplier_payment_info_shop_info1_idx` (`shop_id`),
  KEY `fk_supplier_payment_info_suppliers1_idx` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `supplier_payment_info`
  ADD CONSTRAINT `fk_supplier_payment_info_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supplier_payment_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `supplier_transaction_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `lot_no` varchar(200) DEFAULT '',
  `name` varchar(200) DEFAULT '', 
  `quantity` varchar(200) DEFAULT '',
  `unit_price` varchar(200) DEFAULT '',
  `sub_total` varchar(200) DEFAULT '',
  `payment_status` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_supplier_transaction_info_shop_info1_idx` (`shop_id`),
  KEY `fk_supplier_transaction_info_suppliers1_idx` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `supplier_transaction_info`
  ADD CONSTRAINT `fk_supplier_transaction_info_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supplier_transaction_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 

-- --------------------------------Customer payment record ---------------------------
CREATE TABLE IF NOT EXISTS `customer_payment_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `amount` double default 0,
  `description` varchar(200) DEFAULT NULL,
  `reference_id` varchar(200) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer_payment_info_shop_info1_idx` (`shop_id`),
  KEY `fk_customer_payment_info_customers1_idx` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `customer_payment_info`
  ADD CONSTRAINT `fk_customer_payment_info_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_payment_info_shop_info1` FOREIGN KEY (`shop_id`) REFERENCES `shop_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `customer_transaction_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `lot_no` varchar(200) DEFAULT '',
  `name` varchar(200) DEFAULT '', 
  `quantity` varchar(200) DEFAULT '',
  `unit_price` varchar(200) DEFAULT '',
  `sub_total` varchar(200) DEFAULT '',
  `payment_status` varchar(200) DEFAULT '',
  `profit` varchar(200) DEFAULT '',
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

