-- DROP TABLE IF EXISTS `xr_article`;
CREATE TABLE IF NOT EXISTS `xr_article` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(150) NOT NULL,
  `keywords` varchar(150) NOT NULL,
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
  `views` mediumint(5) unsigned NOT NULL default '0',
  `sticky` enum('0','1','2','3') NOT NULL default '0',
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `order` (`order`),
  KEY `views` (`views`),
  KEY `sticky` (`sticky`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_articleCategory`;
CREATE TABLE IF NOT EXISTS `xr_articleCategory` (
  `article` mediumint(9) NOT NULL,
  `category` smallint(5) NOT NULL,
  UNIQUE KEY `article` (`article`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_block`;
CREATE TABLE IF NOT EXISTS `xr_block` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` varchar(10) NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_comment`;
CREATE TABLE IF NOT EXISTS `xr_comment` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `objectType` varchar(30) NOT NULL default '',
  `objectID` mediumint(8) unsigned NOT NULL default '0',
  `author` varchar(30) NOT NULL,
  `email` varchar(90) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `object` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_file`;
CREATE TABLE IF NOT EXISTS `xr_file` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `pathname` char(50) NOT NULL,
  `title` char(90) NOT NULL,
  `extension` char(30) NOT NULL,
  `size` mediumint(8) unsigned NOT NULL default '0',
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `addedBy` char(30) NOT NULL default '',
  `addedDate` datetime NOT NULL,
  `public` enum('1','0') NOT NULL default '1',
  `downloads` mediumint(8) unsigned NOT NULL default '0',
  `extra` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `object` (`objectType`,`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_layout`;
CREATE TABLE IF NOT EXISTS `xr_layout` (
  `page` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `blocks` varchar(255) NOT NULL,
  UNIQUE KEY `layout` (`page`,`region`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_message`;
CREATE TABLE IF NOT EXISTS `xr_message` (
  `id` mediumint(8) NOT NULL auto_increment,
  `from` char(30) NOT NULL default 'system',
  `to` char(30) NOT NULL,
  `content` varchar(255) NOT NULL,
  `link` varchar(100) NOT NULL,
  `time` datetime NOT NULL,
  `readed` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `readed` (`readed`),
  KEY `to` (`to`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_category`;
CREATE TABLE IF NOT EXISTS `xr_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` char(30) NOT NULL default '',
  `desc` varchar(150) NOT NULL,
  `keyword` varchar(150) NOT NULL,
  `parent` smallint(5) unsigned NOT NULL default '0',
  `path` char(255) NOT NULL default '',
  `grade` tinyint(3) unsigned NOT NULL default '0',
  `order` smallint(5) unsigned NOT NULL default '0',
  `tree` char(30) NOT NULL,
  `readonly` enum('0','1') NOT NULL default '0',
  `owners` varchar(255) NOT NULL,
  `threads` smallint(5) NOT NULL,
  `posts` smallint(5) NOT NULL,
  `lastPostedBy` varchar(30) NOT NULL,
  `lastPostedDate` datetime NOT NULL,
  `lastPostID` mediumint(9) NOT NULL,
  `lastReplyID` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `tree` (`tree`),
  KEY `order` (`order`),
  KEY `parent` (`parent`),
  KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_reply`;
CREATE TABLE IF NOT EXISTS `xr_reply` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `thread` mediumint(8) unsigned NOT NULL,
  `content` text NOT NULL,
  `author` char(30) NOT NULL,
  `editor` char(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `thread` (`thread`),
  KEY `author` (`author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_thread`;
CREATE TABLE IF NOT EXISTS `xr_thread` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `site` smallint(6) NOT NULL,
  `category` mediumint(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `readonly` tinyint(1) NOT NULL,
  `views` smallint(5) unsigned NOT NULL default '0',
  `stick` enum('0','1','2','3') NOT NULL default '0',
  `replies` smallint(6) NOT NULL,
  `lastRepliedBy` varchar(30) NOT NULL,
  `lastRepliedDate` datetime NOT NULL,
  `lastReplyID` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `category` (`category`),
  KEY `site` (`site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_user`;
CREATE TABLE IF NOT EXISTS `xr_user` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `account` char(30) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `realname` char(30) NOT NULL default '',
  `nickname` char(60) NOT NULL default '',
  `admin` ENUM( 'no', 'common', 'super' ) NOT NULL DEFAULT 'no',
  `avatar` char(30) NOT NULL default '',
  `birthday` date NOT NULL,
  `gendar` enum('f','m','u') NOT NULL default 'u',
  `email` char(90) NOT NULL default '',
  `skype` char(90) NOT NULL,
  `qq` char(20) NOT NULL default '',
  `yahoo` char(90) NOT NULL default '',
  `gtalk` char(90) NOT NULL default '',
  `wangwang` char(90) NOT NULL default '',
  `site` varchar(100) NOT NULL,
  `mobile` char(11) NOT NULL default '',
  `phone` char(20) NOT NULL default '',
  `company` varchar(255) NOT NULL,
  `address` char(120) NOT NULL default '',
  `zipcode` char(10) NOT NULL default '',
  `visits` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(15) NOT NULL default '',
  `last` datetime NOT NULL,
  `referer` varchar(255) NOT NULL,
  `addedDate` datetime NOT NULL,
  `resetKey` char(64) NOT NULL,
  `resetTime` datetime NOT NULL,
  `allowTime` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `admin` (`admin`),
  KEY `account` (`account`,`password`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- DROP TABLE IF EXISTS `xr_config`;
CREATE TABLE IF NOT EXISTS `xr_config` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `owner` char(30) NOT NULL default '',
  `module` varchar(30) NOT NULL,
  `section` char(30) NOT NULL default '',
  `key` char(30) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`owner`,`module`,`section`,`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
