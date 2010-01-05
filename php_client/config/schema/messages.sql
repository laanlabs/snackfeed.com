

-- NOTES
-- 	To get public posts by user 1, lookup WHERE recipient_user_id = 1 AND recipient_type_id = 1
-- 	
-- 	To get private to user 1, lookup WHERE recipient_type_id = 1 AND recipient_type_id = 0
-- 	
-- indices for:
-- JOIN USING message_id
-- WHERE recipient_user_id AND recipient_type_id
-- WHERE recipient_user_id AND recipient_type_id AND read_by_recipient
DROP TABLE IF EXISTS `message_recipients`;
CREATE TABLE `message_recipients` (
  `message_id` char(36) NOT NULL,
  `recipient_user_id` int(11) NOT NULL default '0',
  `recipient_type_id` tinyint(3) NOT NULL default '0' COMMENT 'can be small.  basically a public-private flag',
  `read_by_recipient` tinyint(1) NOT NULL default '0',

  PRIMARY KEY (`message_id`, `recipient_user_id`, `recipient_type_id`),
  KEY `recipient_and_type_MULTI` (`recipient_user_id`, `recipient_type_id`),
  KEY `read_IX` (`read_by_recipient`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--####################################################################################################


-- NOTES
-- 	get recipeients from message_recipients table
-- 	get attached vids from message_links table with content_type_id = 1
-- 
-- indices for:
-- JOIN USING message_id
-- JOIN ON sender_user_id
-- WHERE message_id
-- WHERE sender_user_id
-- ORDER BY time_created
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `message_id` char(36) NOT NULL default '0',
  `sender_user_id` int(11) NOT NULL default '0',
  `text` text,
  `time_created` timestamp NOT NULL default CURRENT_TIMESTAMP,

  PRIMARY KEY  (`message_id`),
  KEY `sender_user_id_FK` (`sender_user_id`),
  KEY `time_created_IX` (`time_created`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--####################################################################################################


-- indices for:
-- JOIN USING message_id AND content_type_id = 1 -- may need to EXPLAIN to figure out if PK is good for this
-- WHERE user_id
DROP TABLE IF EXISTS `message_links`;
CREATE TABLE `message_links` (
  `message_id` char(36) NOT NULL default '0',
  `content_id` char(36) NOT NULL default '0',
  `content_type_id` tinyint(3) NOT NULL default '0' COMMENT 'eg 0 for video, 1 for other',

  PRIMARY KEY  (`message_id`, `content_type_id`, `content_id`),
  KEY `content_id_FK` (`content_id`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--####################################################################################################



--####################################################################################################
-- TRIGGERS
--####################################################################################################

