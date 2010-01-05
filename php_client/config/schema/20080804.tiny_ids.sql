drop table tiny_ids;
CREATE TABLE `tiny_ids` (
  `tiny_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `video_id` char(36) NOT NULL,
  `time_created` timestamp DEFAULT NOW(),
  PRIMARY KEY (`tiny_id`),
  KEY time_created_ix (`time_created`)
) ENGINE=innoDB DEFAULT CHARSET=utf8;

DELIMITER |
DROP TRIGGER IF EXISTS after_insert_video |
CREATE TRIGGER after_insert_video AFTER INSERT ON videos
FOR EACH ROW BEGIN
  INSERT INTO tiny_ids
  SET tiny_ids.video_id = NEW.video_id;
END; 
|

DELIMITER |
DROP TRIGGER IF EXISTS after_delete_video |
CREATE TRIGGER after_delete_video AFTER DELETE ON videos
FOR EACH ROW BEGIN
  DELETE FROM tiny_ids
  WHERE tiny_ids.video_id = OLD.video_id;
END; 
|

INSERT INTO tiny_ids (video_id) SELECT video_id FROM videos;

_____________
CHANGED TO 

________

create tiny_id field
select @m:=0; update videos set tiny_id =(@m:=@m+1)

DELIMITER |
DROP TRIGGER IF EXISTS after_insert_video |
CREATE TRIGGER after_insert_video BEFORE INSERT ON videos
FOR EACH ROW BEGIN
 SET  NEW.tiny_id = (SELECT count(v.tiny_id) FROM videos v) + 1;
END