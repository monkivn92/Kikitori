CREATE TABLE  IF NOT EXISTS `#__xrds_portals` (
  `id` integer NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `home_url` varchar(255) default NULL,
  `login_url` varchar(255) default NULL,
  `registration_url` varchar(255) default NULL,  
  `keywords` text default NULL,
  `description` text default NULL,
  `address` varchar(255) default NULL,
  `logo` varchar(255) default NULL,
  `state` tinyint(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL DEFAULT '0', 
  PRIMARY KEY  (`id`)
)  DEFAULT CHARSET=utf8;

