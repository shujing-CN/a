ALTER TABLE `zan_users` DROP `hthz`;
DELETE FROM `zan_config` WHERE `zan_config`.`k` = \'hthz\';
UPDATE `zan_config` SET `v` = '1300' WHERE `zan_config`.`k` = 'ver';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = \'beian\';
ALTER TABLE `zan_logs` CHANGE `qq` `qq` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
DROP TABLE `zan_invites`, `zan_lists`;
CREATE TABLE IF NOT EXISTS `zan_pay` (
  `orderno` varchar(255) NOT NULL,
  `addtime` varchar(255) NOT NULL,
  `endtime` varchar(255) DEFAULT NULL,
  `money` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `jifen` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL COMMENT '购买ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DELETE FROM `zan_config` WHERE `zan_config`.`k` = \'sitekey\'';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = \'cronkey\';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = 'beian';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = 'bottom';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = 'cronkey';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = 'hthz';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = 'payurl';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = 'sitekey';
DELETE FROM `zan_config` WHERE `zan_config`.`k` = 'type';
INSERT INTO `zan_config` (`k`, `v`) VALUES ('app_url', ''), ('bottom', '{"index":"","tool":"","huzan":"","jifen":"","user":"","dibu":""}'), ('is_pay', '0'), ('pay', '{"is_pay":"1","url":"http://qq/","id":"1001","key":"key","submit":"u7acbu5373u4feeu6539"}'), ('qqlogin', '{"login_api":"","is_yz":"0","submit":"u7acbu5373u4feeu6539"}'), ('qun', ''), ('server', '1');