DROP TABLE IF EXISTS `full_search_search`;

CREATE TABLE `full_search_search` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `additional` text DEFAULT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `object` varchar(255) NOT NULL DEFAULT '',
  `object_pk` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;