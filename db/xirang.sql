-- DROP TABLE IF EXISTS `xr_article`;
CREATE TABLE `xr_article` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `original` enum('1','0') NOT NULL,
  `copySite` varchar(60) NOT NULL,
  `copyURL` varchar(255) NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `type` varchar(30) NOT NULL,
  `views` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `stick` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `order` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order` (`order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_block`;
CREATE TABLE `xr_block` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `site` smallint(3) unsigned NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_comment`;
CREATE TABLE `xr_comment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` varchar(30) NOT NULL DEFAULT '',
  `objectID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `author` varchar(30) NOT NULL,
  `email` varchar(90) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `objectType` (`objectType`),
  KEY `objectID` (`objectID`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_file`;
CREATE TABLE `xr_file` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pathname` char(50) NOT NULL,
  `title` char(90) NOT NULL,
  `extension` char(30) NOT NULL,
  `size` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `addedBy` char(30) NOT NULL DEFAULT '',
  `addedDate` datetime NOT NULL,
  `public` enum('1','0') NOT NULL DEFAULT '1',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `objectType` (`objectType`),
  KEY `objectID` (`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_layout`;
CREATE TABLE `xr_layout` (
  `site` smallint(5) unsigned NOT NULL,
  `page` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `blocks` varchar(255) NOT NULL,
  UNIQUE KEY `unikey` (`site`,`page`,`region`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_message`;
CREATE TABLE `xr_message` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `from` char(30) NOT NULL DEFAULT 'system',
  `to` char(30) NOT NULL,
  `content` varchar(255) NOT NULL,
  `link` varchar(100) NOT NULL,
  `time` datetime NOT NULL,
  `readed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_module`;
CREATE TABLE `xr_module` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `site` mediumint(8) unsigned NOT NULL,
  `name` char(30) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tree` char(30) NOT NULL,
  `readonly` tinyint(3) unsigned NOT NULL,
  `owners` varchar(255) NOT NULL,
  `threads` mediumint(9) NOT NULL,
  `posts` mediumint(9) NOT NULL,
  `price` float NOT NULL,
  `lastPostedBy` varchar(30) NOT NULL,
  `lastPostedDate` datetime NOT NULL,
  `lastPostID` mediumint(9) NOT NULL,
  `lastReplyID` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_reply`;
CREATE TABLE `xr_reply` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `site` smallint(6) NOT NULL,
  `thread` mediumint(8) unsigned NOT NULL,
  `content` text NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `thread` (`thread`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_site`;
CREATE TABLE `xr_site` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `domain` varchar(30) NOT NULL,
  `code` varchar(30) NOT NULL,
  `logo` varchar(60) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `mission` text NOT NULL,
  `theme` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `indexModules` varchar(100) NOT NULL,
  `menus` text NOT NULL,
  `linkSites` varchar(255) NOT NULL,
  `admins` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `domain` (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_thread`;
CREATE TABLE `xr_thread` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `site` smallint(6) NOT NULL,
  `module` mediumint(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `readonly` tinyint(1) NOT NULL,
  `views` smallint(5) unsigned NOT NULL DEFAULT '0',
  `stick` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `replies` smallint(6) NOT NULL,
  `lastRepliedBy` varchar(30) NOT NULL,
  `lastRepliedDate` datetime NOT NULL,
  `lastReplyID` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `site` (`site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_user`;
CREATE TABLE `xr_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `site` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `account` char(30) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `resetKey` char(64) CHARACTER SET ucs2 NOT NULL,
  `resetedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `realname` char(30) NOT NULL DEFAULT '',
  `nickname` char(60) NOT NULL DEFAULT '',
  `avatar` char(30) NOT NULL DEFAULT '',
  `birthyear` smallint(5) unsigned NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `gendar` enum('f','m','u') NOT NULL DEFAULT 'u',
  `email` char(90) NOT NULL DEFAULT '',
  `msn` char(90) NOT NULL DEFAULT '',
  `qq` char(20) NOT NULL DEFAULT '',
  `yahoo` char(90) NOT NULL DEFAULT '',
  `gtalk` char(90) NOT NULL DEFAULT '',
  `wangwang` char(90) NOT NULL DEFAULT '',
  `webSite` varchar(100) NOT NULL,
  `alipay` varchar(100) NOT NULL,
  `mobile` char(11) NOT NULL DEFAULT '',
  `phone` char(20) NOT NULL DEFAULT '',
  `company` varchar(255) NOT NULL,
  `address` char(120) NOT NULL DEFAULT '',
  `zipcode` char(10) NOT NULL DEFAULT '',
  `join` date NOT NULL DEFAULT '0000-00-00',
  `visits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `last` datetime NOT NULL,
  `allowTime` datetime NOT NULL,
  `referer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `xr_article` ADD `module` SMALLINT( 6 ) NOT NULL AFTER `editedDate`; 
