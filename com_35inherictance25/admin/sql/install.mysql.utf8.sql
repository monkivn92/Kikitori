CREATE TABLE `#__xrds_portals` (
  `id` integer NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `home_url` varchar(255) default NULL,
  `login_url` varchar(255) default NULL,
  `registration_url` varchar(255) default NULL,  
  `keywords` text default NULL,
  `description` text default NULL,
  `address` varchar(255) default NULL,
  `logo` varchar(255) default NULL,
  `published` tinyint(4) default 0,
  `ordering`  integer default 0,
  PRIMARY KEY  (`id`)
)  DEFAULT CHARSET=utf8;

