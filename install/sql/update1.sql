INSERT INTO `zan_config` VALUES('fhurl', '0');
INSERT INTO `zan_config` VALUES('img1', '/assets/img/img_aa9b9c8dfc48d120f4b5c6e9ada6e7da.png');
INSERT INTO `zan_config` VALUES('img1_url', '/index/huzan/jifen');
INSERT INTO `zan_config` VALUES('img2', '/assets/img/img_9f77d29f2db0ea84d8211f91a1b1e949.png');
INSERT INTO `zan_config` VALUES('img2_url', '/');
INSERT INTO `zan_config` VALUES('img3', '/assets/img/img_d6ebb71d04f53097a5948ec4f2912915.png');
INSERT INTO `zan_config` VALUES('img3_url', '/index/huzan/jifen/tuiguang');
INSERT INTO `zan_config` VALUES('type', '0');
INSERT INTO `zan_config` VALUES('cronkey', substr(md5(rand()),1,16));
INSERT INTO `zan_config` VALUES('crontime', '0000-00-00 00:00:00');
INSERT INTO `zan_config` VALUES('ver', '1100');
INSERT INTO `zan_config` VALUES('sitekey', substr(md5(rand()),1,16));

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `zan_logs` (
  `id` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `type` text NOT NULL,
  `jifen` int(11) NOT NULL,
  `addtime` datetime NOT NULL,
  `msg` text NOT NULL,
  `qq` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zan_users` (
  `id` int(11) NOT NULL,
  `status` int(1) DEFAULT '0',
  `qq` varchar(10) NOT NULL,
  `skey` varchar(200) DEFAULT NULL,
  `pskey` varchar(200) DEFAULT NULL,
  `addtime` datetime DEFAULT '0000-00-00 00:00:00',
  `logintime` datetime DEFAULT '0000-00-00 00:00:00',
  `zan_time` datetime DEFAULT '0000-00-00 00:00:00',
  `fail_time` datetime DEFAULT '0000-00-00 00:00:00',
  `jifen` int(11) DEFAULT '0',
  `name` text,
  `yishangxian` text,
  `beizan_time` datetime DEFAULT '0000-00-00 00:00:00',
  `vip_time` datetime DEFAULT '0000-00-00 00:00:00',
  `hthz` int(11) NOT NULL DEFAULT '0' COMMENT '后台互赞'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

ALTER TABLE `zan_logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zan_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zan_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `zan_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;