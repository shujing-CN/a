-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2020-03-21 05:41:43
-- 服务器版本： 5.7.29-log
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `testhz`
--

-- --------------------------------------------------------

--
-- 表的结构 `zan_config`
--

CREATE TABLE IF NOT EXISTS `zan_config` (
  `k` varchar(32) NOT NULL,
  `v` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zan_config`
--

INSERT INTO `zan_config` (`k`, `v`) VALUES
('app_url', ''),
('bottom', '{"index":"","tool":"","huzan":"","jifen":"","user":"","dibu":""}'),
('build', '2020-02-13'),
('crontime', '2020-03-21 00:01:26'),
('description', '香程互赞宝创始于2020年2月5日，每天只要扫一扫，就可以免费获得500~5000赞！'),
('edu', '50'),
('fhurl', '0'),
('img1', 'http://oss.v8tao.cn/img/lunbo_1.jpg'),
('img1_url', '?mod=jifen'),
('img2', 'http://oss.v8tao.cn/img/lunbo_2.jpg'),
('img2_url', '/'),
('img3', 'http://oss.v8tao.cn/img/lunbo_3.jpg'),
('img3_url', '?mod=tool'),
('is_pay', '0'),
('keywords', '互赞宝,领赞宝,香程互赞宝,云上互赞,免费刷赞'),
('kfqq', '77903161'),
('login_pwd', '123456'),
('login_user', 'admin'),
('pay', '{"is_pay":"1","url":"http://qq/","id":"1001","key":"key","submit":"u7acbu5373u4feeu6539"}'),
('pinlv', '300'),
('qie', '{"yjqd":"0","delss":"200","delly":"160","tmtx":"800","kbwm":"650","jjtj":"700","ycss":"850","regtime":"2800","tbgx":"3000","lysh":"1000","plsh":"500","hysc":"180","money":"10","submit":"u7acbu5373u4feeu6539"}'),
('qqjump', '1'),
('qqlogin', '{"login_api":"","is_yz":"0","submit":"u7acbu5373u4feeu6539"}'),
('qun', ''),
('server', '1'),
('sitename', '香程互赞宝'),
('title', '您的互赞助手！'),
('ver', '1300');

-- --------------------------------------------------------

--
-- 表的结构 `zan_logs`
--

CREATE TABLE IF NOT EXISTS `zan_logs` (
  `id` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `type` text NOT NULL,
  `jifen` int(11) NOT NULL,
  `addtime` datetime NOT NULL,
  `msg` text NOT NULL,
  `qq` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zan_pay`
--

CREATE TABLE IF NOT EXISTS `zan_pay` (
  `orderno` varchar(255) NOT NULL,
  `addtime` varchar(255) NOT NULL,
  `endtime` varchar(255) DEFAULT NULL,
  `money` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `jifen` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL COMMENT '购买ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zan_users`
--

CREATE TABLE IF NOT EXISTS `zan_users` (
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
  `edu` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zan_config`
--
ALTER TABLE `zan_config`
  ADD PRIMARY KEY (`k`);

--
-- Indexes for table `zan_logs`
--
ALTER TABLE `zan_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zan_pay`
--
ALTER TABLE `zan_pay`
  ADD PRIMARY KEY (`orderno`);

--
-- Indexes for table `zan_users`
--
ALTER TABLE `zan_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `zan_logs`
--
ALTER TABLE `zan_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `zan_users`
--
ALTER TABLE `zan_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;