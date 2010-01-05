ALTER TABLE users ADD UNIQUE INDEX `nickname_ux` (`nickname`);

drop table pseudo_users;
CREATE TABLE `pseudo_users` (
  `pseudo_user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `time_created` timestamp DEFAULT NOW(),
  PRIMARY KEY (`pseudo_user_id`),
  KEY time_created_ix (`time_created`)
) ENGINE=innoDB DEFAULT CHARSET=utf8;

drop table history_ids;
CREATE TABLE `history_ids` (
  `history_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `time_created` timestamp DEFAULT NOW(),
  PRIMARY KEY (`history_id`),
  KEY time_created_ix (`time_created`)
) ENGINE=innoDB DEFAULT CHARSET=utf8;

drop table history_items;

CREATE TABLE `history_items` (
  `history_item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `history_id` int UNSIGNED NOT NULL,
  `video_id` char(36),
  `user_id` char(36),
  `parent_id` char(36),
  `pseudo_user_id` int UNSIGNED NOT NULL,
  `time_created` timestamp DEFAULT NOW(),
  PRIMARY KEY (`history_item_id`),
  KEY history_id_fk (`history_id`),
  KEY video_id_fk (`video_id`),
  KEY user_id_fk (`user_id`),
  KEY pseudo_user_id_fk (`pseudo_user_id`),
  KEY video_user_multi (`video_id`, `user_id`),
  KEY video_pseudo_user_multi (`video_id`, `pseudo_user_id`),
  KEY time_created_ix (`time_created`)
) ENGINE=innoDB DEFAULT CHARSET=utf8;



