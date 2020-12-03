/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 10.1.36-MariaDB : Database - db_wisata_dev
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `m_halaman_web` */

DROP TABLE IF EXISTS `m_halaman_web`;

CREATE TABLE `m_halaman_web` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_key` char(20) NOT NULL,
  `icon` char(50) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `konten` text,
  `site_url` varchar(255) DEFAULT NULL,
  `is_use_style` smallint(2) DEFAULT '2' COMMENT '1=pakek style, 2=tidak',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `m_halaman_web` */

insert  into `m_halaman_web`(`id`,`app_key`,`icon`,`judul`,`konten`,`site_url`,`is_use_style`,`created_at`,`updated_at`) values 
(1,'P_CONTACT','fa fa-phone','Phone','085646910808',NULL,2,'2020-12-02 17:52:46','2020-12-02 17:52:46'),
(2,'EMAIL','fa fa-envelope','Email','dewiradarma@gmail.com',NULL,2,'2020-12-02 17:53:16','2020-12-02 17:53:16'),
(3,'ABOUT',NULL,'About Us','peng empu adalah air terjun. Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.',NULL,1,NULL,NULL),
(4,'SOSMED','fa fa-facebook','Halaman Facebook','<a href=\"#\">Halaman Facebook</a>','https://www.facebook.com/',2,NULL,NULL),
(5,'SOSMED','fa fa-twitter','Halaman Twitter','<a>Halaman Twitter</a>','https://twitter.com/',2,NULL,NULL),
(6,'SOSMED','fa fa-youtube','Halaman Youtube','<a>Halaman Youtube</a>','https://youtube.com/',2,NULL,NULL);

/*Table structure for table `m_slide_show` */

DROP TABLE IF EXISTS `m_slide_show`;

CREATE TABLE `m_slide_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tema` varchar(100) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `url_gambar` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `m_slide_show` */

insert  into `m_slide_show`(`id`,`tema`,`judul`,`deskripsi`,`url_gambar`,`created_at`,`updated_at`) values 
(1,'Welcome To Varsity','We Will Help You To Learn','Lorem ipsum dolor sit amet, consectetur adipisicing elit. \r\nDolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.','',NULL,NULL),
(2,'Welcome To Varsity 2','We Will Help You To Learn','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor amet error eius ','',NULL,NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id`,`role_name`,`created_at`,`updated_at`) values 
(1,'Admin',NULL,NULL),
(2,'User',NULL,NULL);

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user_roles` */

insert  into `user_roles`(`id`,`user_id`,`role_id`,`created_at`,`updated_at`) values 
(1,1,1,NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'I Gede Wira Darma','dewiradarma@gmail.com',NULL,'$2y$10$y7FYI2id/Wmst7igUsmgEeCN/Sg6M60evrbag0.q.Oi3k.1VNYjWi','oh3mTfjE48T7BzpqNA3NSDEttXEaPiye0a0QzRIHqYNzc82kxKjkJK6kPJBK','2020-11-19 20:37:28','2020-11-19 20:37:28'),
(2,'Adi Panca','adipanca@gmail.com',NULL,'$2y$10$vnGi/sJfc0Hhnr3toJ98GOFXg4O2E/6u5Qc1DHTKUd/UG82EeT2Ku',NULL,'2020-11-20 03:47:52','2020-11-20 03:47:52');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
