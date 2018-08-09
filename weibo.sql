-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-08-07 21:01:33
-- 服务器版本： 5.5.57-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weibo`
--

-- --------------------------------------------------------

--
-- 表的结构 `weibo_save`
--

CREATE TABLE `weibo_save` (
  `id` int(5) NOT NULL,
  `wb_id` text NOT NULL COMMENT '微博编号',
  `wb_url` varchar(150) NOT NULL COMMENT '微博链接',
  `wb_time` varchar(20) NOT NULL COMMENT '发布时间',
  `get_time` int(10) NOT NULL COMMENT '抓取时间',
  `wb_text` varchar(400) NOT NULL COMMENT '微博内容',
  `wb_textLength` int(4) NOT NULL COMMENT '微博字数',
  `wb_source` varchar(10) NOT NULL COMMENT '发布设备',
  `wb_userid` varchar(10) NOT NULL COMMENT '发布ID',
  `wb_username` varchar(10) NOT NULL COMMENT '发布昵称',
  `wb_profile_image` varchar(150) NOT NULL COMMENT '主页头像',
  `wb_profile_url` varchar(150) NOT NULL COMMENT '主页链接',
  `wb_statuses` int(3) NOT NULL COMMENT '微博等级',
  `wb_description` varchar(100) DEFAULT NULL COMMENT '微博签名',
  `wb_image1_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_image2_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_image3_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_image4_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_image5_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_image6_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_image7_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_image8_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_image9_url` varchar(150) DEFAULT NULL COMMENT '发布图片',
  `wb_retweeted_text` varchar(400) DEFAULT NULL COMMENT '转发内容',
  `wb_retweeted_time` varchar(10) DEFAULT NULL COMMENT '转发时间',
  `wb_retweeted_id` int(10) DEFAULT NULL COMMENT '转发id',
  `wb_retweeted_name` varchar(15) DEFAULT NULL COMMENT '转发昵称',
  `wb_retweeted_description` varchar(100) DEFAULT NULL COMMENT '转发签名',
  `wb_retweeted_count` int(8) DEFAULT NULL COMMENT '转发粉丝'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weibo_save`
--
ALTER TABLE `weibo_save`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `weibo_save`
--
ALTER TABLE `weibo_save`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
