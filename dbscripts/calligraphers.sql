/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50621
 Source Host           : localhost
 Source Database       : wxtest

 Target Server Type    : MySQL
 Target Server Version : 50621
 File Encoding         : utf-8

 Date: 06/19/2016 22:11:41 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `calligraphers`
-- ----------------------------
DROP TABLE IF EXISTS `calligraphers`;
CREATE TABLE `calligraphers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `photo_url` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `gender` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `nation` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `native` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `aptitude` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `company` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `tel` varchar(255) DEFAULT '',
  `birthday` int(11) DEFAULT '0',
  `country_id` int(11) DEFAULT '0',
  `province_id` int(11) DEFAULT '0',
  `city_id` int(11) DEFAULT '0',
  `county_id` int(11) DEFAULT '0',
  `address` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `piece_url` varchar(255) DEFAULT '' COMMENT '作品地址',
  `recorder_id` int(11) DEFAULT '0',
  `read_total` int(11) DEFAULT '0',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
