/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.52-MariaDB : Database - s2s_test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `blocks` */

DROP TABLE IF EXISTS `blocks`;

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text,
  `before_block` text,
  `after_block` text,
  `before_title` text,
  `after_title` text,
  `cells` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `blocks` */

/*Table structure for table `blocks_phinxlog` */

DROP TABLE IF EXISTS `blocks_phinxlog`;

CREATE TABLE `blocks_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `blocks_phinxlog` */

insert  into `blocks_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161010220529,'Blocks','2017-06-12 10:20:35','2017-06-12 10:20:35');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `parent_id` int(20) DEFAULT NULL,
  `lft` int(20) DEFAULT NULL,
  `rght` int(20) DEFAULT NULL,
  `meta_category_id` int(20) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

/*Table structure for table `category_contents` */

DROP TABLE IF EXISTS `category_contents`;

CREATE TABLE `category_contents` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `content_id` int(20) DEFAULT NULL,
  `category_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `category_contents` */

/*Table structure for table `category_metas` */

DROP TABLE IF EXISTS `category_metas`;

CREATE TABLE `category_metas` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text,
  `category_id` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `category_metas` */

/*Table structure for table `content_metas` */

DROP TABLE IF EXISTS `content_metas`;

CREATE TABLE `content_metas` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text,
  `content_id` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `content_metas` */

/*Table structure for table `contents` */

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `excerpt` text,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `hits` int(20) DEFAULT '0',
  `meta_type_id` int(20) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT '0',
  `featured` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `contents` */

/*Table structure for table `contents_phinxlog` */

DROP TABLE IF EXISTS `contents_phinxlog`;

CREATE TABLE `contents_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `contents_phinxlog` */

insert  into `contents_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161010220634,'Contents','2017-06-12 10:20:35','2017-06-12 10:20:35');

/*Table structure for table `extensions_phinxlog` */

DROP TABLE IF EXISTS `extensions_phinxlog`;

CREATE TABLE `extensions_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `extensions_phinxlog` */

insert  into `extensions_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161010221059,'Extensions','2017-06-12 10:20:35','2017-06-12 10:20:35');

/*Table structure for table `galleries` */

DROP TABLE IF EXISTS `galleries`;

CREATE TABLE `galleries` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `parent_id` int(20) DEFAULT NULL,
  `lft` int(20) DEFAULT NULL,
  `rght` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `galleries` */

/*Table structure for table `it_forms_phinxlog` */

DROP TABLE IF EXISTS `it_forms_phinxlog`;

CREATE TABLE `it_forms_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `it_forms_phinxlog` */

/*Table structure for table `ittvn_phinxlog` */

DROP TABLE IF EXISTS `ittvn_phinxlog`;

CREATE TABLE `ittvn_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ittvn_phinxlog` */

/*Table structure for table `languages` */

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `i18n` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `delete` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `languages` */

insert  into `languages`(`id`,`name`,`code`,`i18n`,`image`,`class`,`status`,`delete`,`created`,`modified`) values (1,'Arabic','ar','ar_AA','','flag-sa',0,0,NULL,NULL),(2,'Chinese (Simplified)','zh-CN','zh_CN','','flag-cn',0,0,NULL,NULL),(3,'Chinese (Traditional)','zh-TW','zh_TW','','flag-tw',0,0,NULL,NULL),(4,'English','en','en_US','','flag-us',1,0,NULL,NULL),(5,'Russian','ru','ru_RU','','flag-ru',0,0,NULL,NULL),(6,'Vietnamese','vi','vi_VN','','flag-vn',1,0,NULL,NULL),(7,'Italia','it','it_IT','','flag-it',0,0,NULL,NULL);

/*Table structure for table `locales` */

DROP TABLE IF EXISTS `locales`;

CREATE TABLE `locales` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `msgid` text,
  `domain` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `locales` */

/*Table structure for table `medias` */

DROP TABLE IF EXISTS `medias`;

CREATE TABLE `medias` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `size` int(20) DEFAULT NULL,
  `gallery_id` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `medias` */

/*Table structure for table `medias_phinxlog` */

DROP TABLE IF EXISTS `medias_phinxlog`;

CREATE TABLE `medias_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `medias_phinxlog` */

insert  into `medias_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161212185830,'Medias','2017-06-12 10:20:36','2017-06-12 10:20:36');

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_mega` tinyint(1) DEFAULT '0',
  `is_dropdown` tinyint(1) DEFAULT '0',
  `category_id` int(20) DEFAULT NULL,
  `content_id` int(20) DEFAULT NULL,
  `menutype_id` int(20) DEFAULT NULL,
  `attributes` text,
  `parent_id` int(20) DEFAULT NULL,
  `lft` int(20) DEFAULT NULL,
  `rght` int(20) DEFAULT NULL,
  `order` int(20) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

/*Table structure for table `menus_phinxlog` */

DROP TABLE IF EXISTS `menus_phinxlog`;

CREATE TABLE `menus_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menus_phinxlog` */

insert  into `menus_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161010221148,'Menus','2017-06-12 10:20:36','2017-06-12 10:20:36');

/*Table structure for table `menutypes` */

DROP TABLE IF EXISTS `menutypes`;

CREATE TABLE `menutypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menutypes` */

/*Table structure for table `meta_categories` */

DROP TABLE IF EXISTS `meta_categories`;

CREATE TABLE `meta_categories` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `meta_type_id` int(20) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `meta_categories` */

insert  into `meta_categories`(`id`,`name`,`slug`,`description`,`meta_type_id`,`delete`,`created`,`modified`) values (1,'Categories','categories','Manage category for post',1,0,NULL,NULL);

/*Table structure for table `meta_types` */

DROP TABLE IF EXISTS `meta_types`;

CREATE TABLE `meta_types` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `category` tinyint(1) DEFAULT '0',
  `multi_category` tinyint(1) DEFAULT '1',
  `menu` tinyint(1) DEFAULT '1',
  `delete` tinyint(1) DEFAULT '0',
  `options` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `meta_types` */

insert  into `meta_types`(`id`,`name`,`slug`,`icon`,`description`,`model`,`category`,`multi_category`,`menu`,`delete`,`options`,`created`,`modified`) values (1,'Posts','posts','fa fa-edit','','Contents',1,1,1,0,'{\"hideFeatureImage\":\"0\",\"hideExcerpt\":\"0\",\"hideDescription\":\"0\",\"hideFeatureImage\":\"0\"}',NULL,NULL),(2,'Pages','pages','fa fa-book','','Contents',0,1,1,0,'{\"hideFeatureImage\":\"1\",\"hideExcerpt\":\"1\",\"hideDescription\":\"0\",\"hideFeatureImage\":\"1\"}',NULL,NULL);

/*Table structure for table `metas` */

DROP TABLE IF EXISTS `metas`;

CREATE TABLE `metas` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `options` text,
  `status` tinyint(1) DEFAULT '1',
  `delete` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `metas` */

/*Table structure for table `metas_phinxlog` */

DROP TABLE IF EXISTS `metas_phinxlog`;

CREATE TABLE `metas_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `metas_phinxlog` */

insert  into `metas_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161010221225,'Metas','2017-06-12 10:20:36','2017-06-12 10:20:36');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `url_after_login` varchar(255) DEFAULT NULL,
  `url_after_logout` varchar(255) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`slug`,`url_after_login`,`url_after_logout`,`delete`) values (1,'Admin','admin','','',0),(2,'Customers','customers','','',0),(3,'Public','public','','',0);

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` text,
  `description` varchar(255) DEFAULT NULL,
  `options` text,
  `type` varchar(50) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT '1',
  `order` int(20) DEFAULT '0',
  `global` tinyint(1) DEFAULT '1',
  `delete` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `settings` */

insert  into `settings`(`id`,`name`,`value`,`description`,`options`,`type`,`method`,`editable`,`order`,`global`,`delete`,`created`,`modified`) values (1,'Sites.title','Services to services - New site','Title for site','','text',NULL,1,0,0,0,NULL,NULL),(2,'Sites.admin_email','info@ittvn.com','Email admin for site','','text',NULL,1,0,0,0,NULL,NULL),(3,'Sites.format_date','d-m-Y','Format date system (default: Year-Month-Date)','','text',NULL,1,0,0,0,NULL,NULL),(4,'Sites.format_time','H:i:s','Format time system (default: Hour:Minute:second)','','text',NULL,1,0,0,0,NULL,NULL),(5,'Sites.theme_default','ItThemes','Theme default for site','','text',NULL,0,0,0,0,NULL,NULL),(6,'Sites.theme_admin_default','Templates','Theme default for admin','','text',NULL,0,0,0,0,NULL,NULL),(7,'Sites.plugins','[\"Sites\"]','','','textarea',NULL,0,0,0,0,NULL,NULL),(8,'Sites.meta_keyword','','Meta keyword for site','','text',NULL,1,0,0,0,NULL,NULL),(9,'Sites.meta_description','','Meta description for site','','textarea',NULL,1,0,0,0,NULL,NULL),(10,'Sites.language_default','vi','Default language for site','','select','Extensions.Languages::getList',1,0,0,0,NULL,NULL),(11,'Images.resize','0','Have resize image for site','','checkbox',NULL,1,0,0,0,NULL,NULL),(12,'Images.crop','0','Image have crop','','checkbox',NULL,1,0,0,0,NULL,NULL),(13,'Images.sizes','269x269','Sizes default for resize image','[{\"key\":\"269x269\",\"value\":\"Thumbnail (269x269)\"},{\"key\":\"100x100\",\"value\":\"Small (100x100)\"},{\"key\":\"555x555\",\"value\":\"Medium (555x555)\"},{\"key\":\"1024x1024\",\"value\":\"Large (1024x1024)\"}]','radio',NULL,1,0,0,0,NULL,NULL),(14,'Users.is_register','1','User can register on sites','','checkbox',NULL,1,0,0,0,NULL,NULL),(15,'Users.role_default_register','customers','Role default when user register on sites','','radio','{\"0\":\"Users.Roles::getList\",\"1\":{\"0\":\"slug\"}}',1,0,0,0,NULL,NULL),(16,'Users.fullPermission','super-admin','User can full permission','','select','{\"0\":\"Users.Roles::getList\",\"1\":{\"0\":\"slug\"}}',1,0,0,0,NULL,NULL),(17,'Users.avatar_default','/img/avatar_default.jpg','Avatar defaul for user','','text',NULL,1,0,0,0,NULL,NULL),(18,'Sites.paging_limit','10','Limit paging','','text',NULL,1,0,0,0,NULL,NULL),(19,'Themes.site','ItThemes','Theme for site','','text',NULL,0,0,0,0,NULL,NULL),(20,'Themes.admin','Templates','Theme for admin','','text',NULL,0,0,0,0,NULL,NULL),(21,'Themes.options','{\"ItThemes\":{\"logo\":\"\\/uploads\\/2016\\/12\\/30\\/logo.png\",\"hotline\":\"0907 432 682 - 01222 574 634\"}}','Theme options for template site',NULL,'textarea',NULL,0,0,0,0,NULL,NULL),(22,'Languages.site','vi_VN','Language default for site','','text',NULL,0,0,0,0,NULL,NULL),(23,'Languages.admin','vi_VN','Default language for admin','','text',NULL,0,0,0,0,NULL,NULL),(24,'Images.size_thumbnail',NULL,'Image size for thumbnail',NULL,'text',NULL,1,0,0,0,NULL,NULL);

/*Table structure for table `settings_phinxlog` */

DROP TABLE IF EXISTS `settings_phinxlog`;

CREATE TABLE `settings_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `settings_phinxlog` */

insert  into `settings_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161010221330,'Settings','2017-06-12 10:20:37','2017-06-12 10:20:37');

/*Table structure for table `sites_phinxlog` */

DROP TABLE IF EXISTS `sites_phinxlog`;

CREATE TABLE `sites_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sites_phinxlog` */

/*Table structure for table `slideshow` */

DROP TABLE IF EXISTS `slideshow`;

CREATE TABLE `slideshow` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `type` int(1) DEFAULT '0' COMMENT '0: Gallery 1: Category 2: Content',
  `gallery_id` int(20) DEFAULT NULL,
  `category_id` int(20) DEFAULT NULL,
  `content` text,
  `config` text,
  `status` tinyint(1) DEFAULT '1',
  `delete` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `slideshow` */

/*Table structure for table `translates` */

DROP TABLE IF EXISTS `translates`;

CREATE TABLE `translates` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(20) DEFAULT NULL,
  `locale_id` int(20) DEFAULT NULL,
  `msgstr` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `translates` */

/*Table structure for table `translates_phinxlog` */

DROP TABLE IF EXISTS `translates_phinxlog`;

CREATE TABLE `translates_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `translates_phinxlog` */

insert  into `translates_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161026062819,'Translates','2017-06-12 10:20:37','2017-06-12 10:20:37');

/*Table structure for table `user_metas` */

DROP TABLE IF EXISTS `user_metas`;

CREATE TABLE `user_metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text,
  `user_id` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_metas` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `active_code` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `public_key` varchar(255) DEFAULT NULL,
  `private_key` varchar(255) DEFAULT NULL,
  `role_id` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `delete` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`active_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`active_code`,`first_name`,`middle_name`,`last_name`,`username`,`password`,`email`,`avatar`,`sex`,`birthday`,`phone`,`public_key`,`private_key`,`role_id`,`status`,`delete`,`created`,`modified`) values (1,'','Phan','Tuấn','Kiệt','admin1','$2y$10$1xLXFdViff461eozjQWhxuTg81A8.f35R2jg/cB9vrqlwUQmol/Q6','tuankiet2605@gmail.com','',0,NULL,'0907432682','','',1,1,0,'2015-10-22 03:54:56','0016-01-16 20:17:00');

/*Table structure for table `users_phinxlog` */

DROP TABLE IF EXISTS `users_phinxlog`;

CREATE TABLE `users_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users_phinxlog` */

insert  into `users_phinxlog`(`version`,`migration_name`,`start_time`,`end_time`) values (20161010221457,'Users','2017-06-12 10:20:37','2017-06-12 10:20:37');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
