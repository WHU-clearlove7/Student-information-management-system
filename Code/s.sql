-- phpMyAdmin SQL Dump
-- version 3.5.0-beta1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2020 年 06 月 12 日 21:39
-- 服务器版本: 5.5.20
-- PHP 版本: 5.4.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `s`
--

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `Cno` int(11) NOT NULL,
  `Cname` varchar(20) NOT NULL,
  `Cpno` int(11) DEFAULT NULL,
  `Credit` int(11) DEFAULT NULL,
  `Remarks` enum('必修','选修') DEFAULT NULL,
  PRIMARY KEY (`Cno`,`Cname`),
  KEY `Cname` (`Cname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`Cno`, `Cname`, `Cpno`, `Credit`, `Remarks`) VALUES
(1001, 'C语言               ', NULL, 2, '必修'),
(1002, '数据结构            ', 1001, 2, '必修'),
(1003, '计算机结构          ', 1002, 3, '选修'),
(1004, '中国政治            ', NULL, 2, '必修'),
(1005, '西方政治            ', 1004, 2, '必修'),
(1006, '世界格局            ', 1005, 3, '选修'),
(1007, '植物结构            ', NULL, 2, '必修'),
(1008, '动物结构            ', 1007, 2, '必修'),
(1009, '人体结构            ', 1008, 3, '选修'),
(1010, '中国经济            ', NULL, 2, '必修'),
(1011, '西方经济            ', 1010, 2, '必修'),
(1012, '世界经济格局        ', 1011, 3, '选修'),
(1013, '力学                ', NULL, 2, '必修'),
(1014, '电磁学              ', 1013, 2, '必修'),
(1015, '量子力学            ', 1014, 3, '选修'),
(1016, '数学分析            ', NULL, 2, '必修'),
(1017, '高等代数            ', 1016, 2, '必修'),
(1018, '高等解析几何        ', 1017, 3, '选修');

--
-- 触发器 `course`
--
DROP TRIGGER IF EXISTS `credit__check`;
DELIMITER //
CREATE TRIGGER `credit__check` BEFORE INSERT ON `course`
 FOR EACH ROW BEGIN
DECLARE ccredit int(11);
SET ccredit=new.Credit;
IF(ccredit>0 AND ccredit<5)THEN
SET@choice=1;
ELSE
SET@choice=0;
INSERT INTO course VALUES(1);
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `sc`
--

CREATE TABLE IF NOT EXISTS `sc` (
  `Sno` int(11) NOT NULL,
  `Sname` varchar(20) NOT NULL DEFAULT '',
  `Cno` int(11) NOT NULL,
  `Cname` char(20) NOT NULL,
  `Score` char(5) DEFAULT NULL,
  PRIMARY KEY (`Sno`,`Sname`,`Cno`,`Cname`),
  KEY `Sname` (`Sname`),
  KEY `Cno` (`Cno`),
  KEY `Cname` (`Cname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sc`
--

INSERT INTO `sc` (`Sno`, `Sname`, `Cno`, `Cname`, `Score`) VALUES
(16001, '王乐欣              ', 1001, 'C语言', 'OTI='),
(16001, '王乐欣              ', 1002, '数据结构', 'OTA='),
(16001, '王乐欣              ', 1003, '计算机结构', 'ODg='),
(16002, '王鸿伟              ', 1001, 'C语言', 'ODk='),
(16002, '王鸿伟              ', 1002, '数据结构', 'OTE='),
(16002, '王鸿伟              ', 1003, '计算机结构', 'OTM='),
(16003, '王白秋              ', 1001, 'C语言', 'Nzc='),
(16003, '王白秋              ', 1002, '数据结构', 'NzI='),
(16003, '王白秋              ', 1003, '计算机结构', 'NjU='),
(16004, '王彩英              ', 1001, 'C语言', 'ODU='),
(16004, '王彩英              ', 1002, '数据结构', 'ODM='),
(16004, '王彩英              ', 1003, '计算机结构', 'ODI='),
(16005, '林诗蕊              ', 1010, '中国经济', 'OTI='),
(16005, '林诗蕊              ', 1011, '西方经济', 'ODc='),
(16005, '林诗蕊              ', 1012, '世界经济格局', 'OTA='),
(16006, '林傲玉              ', 1010, '中国经济', 'OTg='),
(16006, '林傲玉              ', 1011, '西方经济', 'OTY='),
(16006, '林傲玉              ', 1012, '世界经济格局', 'OTI='),
(16007, '林华翰              ', 1010, '中国经济', 'ODg='),
(16007, '林华翰              ', 1011, '西方经济', 'ODY='),
(16007, '林华翰              ', 1012, '世界经济格局', 'ODU='),
(16008, '林同方              ', 1010, '中国经济', 'ODA='),
(16008, '林同方              ', 1011, '西方经济', 'Nzg='),
(16008, '林同方              ', 1012, '世界经济格局', 'NzY='),
(16009, '许飞舟              ', 1016, '数学分析', 'ODI='),
(16009, '许飞舟              ', 1017, '高等代数', 'NzQ='),
(16009, '许飞舟              ', 1018, '高等解析几何', 'ODM='),
(16010, '许嘉良              ', 1016, '数学分析', 'ODK='),
(16010, '许嘉良              ', 1017, '高等代数', 'OTI='),
(16010, '许嘉良              ', 1018, '高等解析几何', 'OTY='),
(16011, '许国安              ', 1016, '数学分析', 'OTA='),
(16011, '许国安              ', 1017, '高等代数', 'ODU='),
(16011, '许国安              ', 1018, '高等解析几何', 'ODM='),
(16012, '许颖颖              ', 1016, '数学分析', 'NzY='),
(16012, '许颖颖              ', 1017, '高等代数', 'NzQ='),
(16012, '许颖颖              ', 1018, '高等解析几何', 'NzU='),
(16013, '温叶彤              ', 1007, '植物结构', 'OTU='),
(16013, '温叶彤              ', 1008, '动物结构', 'ODK='),
(16013, '温叶彤              ', 1009, '人体结构', 'OTI='),
(16014, '温思洁              ', 1007, '植物结构', 'ODU='),
(16014, '温思洁              ', 1008, '动物结构', 'ODQ='),
(16014, '温思洁              ', 1009, '人体结构', 'ODY='),
(16015, '温安娴              ', 1007, '植物结构', 'Nzc='),
(16015, '温安娴              ', 1008, '动物结构', 'ODI='),
(16015, '温安娴              ', 1009, '人体结构', 'ODY='),
(16016, '温子晋              ', 1007, '植物结构', 'ODU='),
(16016, '温子晋              ', 1008, '动物结构', 'ODM='),
(16016, '温子晋              ', 1009, '人体结构', 'NzQ='),
(16017, '徐浩楠              ', 1014, '电磁学', 'OTQ='),
(16018, '徐华清              ', 1014, '电磁学', 'ODU='),
(16019, '徐弘和              ', 1014, '电磁学', 'Nzc='),
(16020, '徐修竹              ', 1014, '电磁学', 'ODI='),
(16021, '徐灵雨              ', 1014, '电磁学', 'ODU='),
(16022, '卢雪巧              ', 1005, '西方政治', 'NzY='),
(16022, '卢雪巧              ', 1006, '世界格局', 'ODI='),
(16023, '卢梦雨              ', 1005, '西方政治', 'OTY='),
(16023, '卢梦雨              ', 1006, '世界格局', 'OTA='),
(16024, '卢亦云              ', 1005, '西方政治', 'ODg='),
(16024, '卢亦云', 1006, '世界格局', 'OTQ=');

-- --------------------------------------------------------

--
-- 表的结构 `selectcourse`
--

CREATE TABLE IF NOT EXISTS `selectcourse` (
  `Sno` int(11) NOT NULL,
  `Sname` char(20) NOT NULL,
  `Cno` int(11) NOT NULL,
  `Cname` char(20) NOT NULL,
  PRIMARY KEY (`Sno`,`Sname`,`Cno`,`Cname`),
  KEY `Sno` (`Sno`),
  KEY `Cno` (`Cno`),
  KEY `Cname` (`Cname`),
  KEY `Sname` (`Sname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `selectcourse`
--

INSERT INTO `selectcourse` (`Sno`, `Sname`, `Cno`, `Cname`) VALUES
(16001, '王乐欣', 1001, 'C语言'),
(16001, '王乐欣', 1002, '数据结构'),
(16001, '王乐欣', 1003, '计算机结构'),
(16002, '王鸿伟', 1001, 'C语言'),
(16002, '王鸿伟', 1002, '数据结构'),
(16002, '王鸿伟', 1003, '计算机结构'),
(16003, '王白秋', 1001, 'C语言'),
(16003, '王白秋', 1002, '数据结构'),
(16003, '王白秋', 1003, '计算机结构'),
(16004, '王彩英', 1001, 'C语言'),
(16004, '王彩英', 1002, '数据结构'),
(16004, '王彩英', 1003, '计算机结构'),
(16005, '林诗蕊', 1010, '中国经济'),
(16005, '林诗蕊', 1011, '西方经济'),
(16005, '林诗蕊', 1012, '世界经济格局'),
(16006, '林傲玉', 1010, '中国经济'),
(16006, '林傲玉', 1011, '西方经济'),
(16006, '林傲玉', 1012, '世界经济格局'),
(16007, '林华翰', 1010, '中国经济'),
(16007, '林华翰', 1011, '西方经济'),
(16007, '林华翰', 1012, '世界经济格局'),
(16008, '林同方', 1010, '中国经济'),
(16008, '林同方', 1011, '西方经济'),
(16008, '林同方', 1012, '世界经济格局'),
(16009, '许飞舟', 1016, '数学分析'),
(16009, '许飞舟', 1017, '高等代数'),
(16009, '许飞舟', 1018, '高等解析几何'),
(16010, '许嘉良', 1016, '数学分析'),
(16010, '许嘉良', 1017, '高等代数'),
(16010, '许嘉良', 1018, '高等解析几何'),
(16011, '许国安', 1016, '数学分析'),
(16011, '许国安', 1017, '高等代数'),
(16011, '许国安', 1018, '高等解析几何'),
(16012, '许颖颖', 1016, '数学分析'),
(16012, '许颖颖', 1017, '高等代数'),
(16012, '许颖颖', 1018, '高等解析几何'),
(16013, '温叶彤', 1007, '植物结构'),
(16013, '温叶彤', 1008, '动物结构'),
(16013, '温叶彤', 1009, '人体结构'),
(16014, '温思洁', 1007, '植物结构'),
(16014, '温思洁', 1008, '动物结构'),
(16014, '温思洁', 1009, '人体结构'),
(16015, '温安娴', 1007, '植物结构'),
(16015, '温安娴', 1008, '动物结构'),
(16015, '温安娴', 1009, '人体结构'),
(16016, '温子晋', 1007, '植物结构'),
(16016, '温子晋', 1008, '动物结构'),
(16016, '温子晋', 1009, '人体结构'),
(16017, '徐浩楠', 1013, '力学'),
(16017, '徐浩楠', 1014, '电磁学'),
(16017, '徐浩楠', 1015, '量子力学'),
(16018, '徐华清', 1013, '力学'),
(16018, '徐华清', 1014, '电磁学'),
(16018, '徐华清', 1015, '量子力学'),
(16019, '徐弘和', 1013, '力学'),
(16019, '徐弘和', 1014, '电磁学'),
(16019, '徐弘和', 1015, '量子力学'),
(16020, '徐修竹', 1013, '力学'),
(16020, '徐修竹', 1014, '电磁学'),
(16020, '徐修竹', 1015, '量子力学'),
(16021, '徐灵雨', 1013, '力学'),
(16021, '徐灵雨', 1014, '电磁学'),
(16021, '徐灵雨', 1015, '量子力学'),
(16022, '卢雪巧', 1004, '中国政治'),
(16022, '卢雪巧', 1005, '西方政治'),
(16022, '卢雪巧', 1006, '世界格局'),
(16023, '卢梦雨', 1004, '中国政治'),
(16023, '卢梦雨', 1005, '西方政治'),
(16023, '卢梦雨', 1006, '世界格局'),
(16024, '卢亦云', 1004, '中国政治'),
(16024, '卢亦云', 1005, '西方政治'),
(16024, '卢亦云', 1006, '世界格局'),
(16025, '卢泰初', 1004, '中国政治'),
(16025, '卢泰初', 1005, '西方政治'),
(16025, '卢泰初', 1006, '世界格局'),
(16025, '卢泰初', 1015, '量子力学');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `Sno` int(11) NOT NULL,
  `Sname` char(20) NOT NULL,
  `Ssex` enum('男','女') DEFAULT NULL,
  `Sage` int(11) DEFAULT NULL,
  `Sdept` char(20) DEFAULT NULL,
  `Class` char(10) DEFAULT NULL,
  PRIMARY KEY (`Sno`,`Sname`),
  UNIQUE KEY `Sno` (`Sno`),
  KEY `Sname` (`Sname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`Sno`, `Sname`, `Ssex`, `Sage`, `Sdept`, `Class`) VALUES
(16001, '王乐欣', '女', 18, '计算机科学', '1班'),
(16002, '王鸿伟', '男', 18, '计算机科学', '2班'),
(16003, '王白秋', '女', 19, '计算机科学', '3班'),
(16004, '王彩英', '女', 19, '计算机科学', '1班'),
(16005, '林诗蕊', '女', 17, '经济管理', '1班'),
(16006, '林傲玉', '女', 19, '经济管理', '2班'),
(16007, '林华翰', '男', 18, '经济管理', '4班'),
(16008, '林同方', '男', 19, '经济管理', '3班'),
(16009, '许飞舟', '男', 18, '数学', '1班'),
(16010, '许嘉良', '男', 19, '数学', '2班'),
(16011, '许国安', '男', 18, '数学', '3班'),
(16012, '许颖颖', '女', 18, '数学', '4班'),
(16013, '温叶彤', '女', 19, '生物', '1班'),
(16014, '温思洁', '女', 18, '生物', '2班'),
(16015, '温安娴', '女', 19, '生物', '3班'),
(16016, '温子晋', '男', 18, '生物', '7班'),
(16017, '徐浩楠', '男', 20, '物理', '1班'),
(16018, '徐华清', '男', 19, '物理', '2班'),
(16019, '徐弘和', '男', 18, '物理', '4班'),
(16020, '徐修竹', '男', 18, '物理', '7班'),
(16021, '徐灵雨', '女', 19, '物理', '3班'),
(16022, '卢雪巧', '女', 18, '政治', '1班'),
(16023, '卢梦雨', '女', 19, '政治', '2班'),
(16024, '卢亦云', '女', 18, '政治', '3班'),
(16025, '卢泰初', '男', 19, '政治', '4班');

--
-- 触发器 `student`
--
DROP TRIGGER IF EXISTS `age__check`;
DELIMITER //
CREATE TRIGGER `age__check` BEFORE INSERT ON `student`
 FOR EACH ROW BEGIN
DECLARE sage int(11);
SET sage=new.Sage;
IF(sage<100 AND sage>0)THEN
SET@choice=1;
ELSE
SET@choice=0;
INSERT INTO student VALUES(1);
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `Tno` int(11) NOT NULL,
  `Tname` varchar(20) NOT NULL,
  `Tsex` enum('男','女') DEFAULT NULL,
  `Tage` int(11) DEFAULT NULL,
  `Tdept` varchar(20) DEFAULT NULL,
  `Tsalary` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Tno`,`Tname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`Tno`, `Tname`, `Tsex`, `Tage`, `Tdept`, `Tsalary`) VALUES
(1, '陈志行              ', '男', 38, '经济管理            ', 'MTIwMDA='),
(2, '赵梦岚              ', '女', 36, '计算机科学          ', 'MTQwMDA='),
(3, '雷阳波              ', '男', 39, '数学                ', 'MTMwMDA='),
(4, '梁同光              ', '男', 42, '物理                ', 'MTgwMDA='),
(5, '刘诗婷              ', '女', 33, '政治                ', 'MTAwMDA='),
(6, '李阳朔              ', '男', 40, '历史                ', 'MTI1MDA='),
(7, '李倩薇              ', '女', 37, '化学                ', 'MTUwMDA='),
(8, '吕阳秋              ', '男', 41, '生物                ', 'MTQ1MDA='),
(9, '张鹏远              ', '男', 39, '城市管理            ', 'OTAwMA=='),
(10, '孙雨', '女', 35, '哲学                ', 'MTIwMDA=');

--
-- 触发器 `teacher`
--
DROP TRIGGER IF EXISTS `tage__check`;
DELIMITER //
CREATE TRIGGER `tage__check` BEFORE INSERT ON `teacher`
 FOR EACH ROW BEGIN
DECLARE tage int(11);
SET tage=new.Tage;
IF(tage<100 AND tage>0)THEN
SET@choice=1;
ELSE
SET@choice=0;
INSERT INTO teacher VALUES(1);
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `accounttype` varchar(10) DEFAULT 'user',
  `name` varchar(255) DEFAULT 'NULL',
  `password` varchar(255) DEFAULT 'NULL',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `accounttype`, `name`, `password`) VALUES
(1, '1', 'root', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'user', 'test', '25f9e794323b453885f5181f1b624d0b'),
(3, 'student', '16001', 'cd73502828457d15655bbd7a63fb0bc8'),
(4, 'teacher', '1', '8d788385431273d11e8b43bb78f3aa41'),
(9, 'Student', '16002', 'cd73502828457d15655bbd7a63fb0bc8'),
(10, 'Teacher', '3', '8d788385431273d11e8b43bb78f3aa41');

--
-- 触发器 `user`
--
DROP TRIGGER IF EXISTS `tri_delete_user`;
DELIMITER //
CREATE TRIGGER `tri_delete_user` AFTER DELETE ON `user`
 FOR EACH ROW begin
    INSERT INTO user_history(user_id,operatetype,operatetime) VALUES (old.id, 'update a user',now());
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tri_insert_user`;
DELIMITER //
CREATE TRIGGER `tri_insert_user` AFTER INSERT ON `user`
 FOR EACH ROW begin
	   INSERT INTO user_history(user_id,operatetype,operatetime) VALUES (new.id, 'add a user',now());
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tri_update_user`;
DELIMITER //
CREATE TRIGGER `tri_update_user` AFTER UPDATE ON `user`
 FOR EACH ROW begin
    INSERT INTO user_history(user_id,operatetype,operatetime) VALUES (new.id, 'update a user',now());
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `user_history`
--

CREATE TABLE IF NOT EXISTS `user_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `operatetype` varchar(200) NOT NULL,
  `operatetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `user_history`
--

INSERT INTO `user_history` (`id`, `user_id`, `operatetype`, `operatetime`) VALUES
(1, 5, 'add a user', '2020-05-31 16:35:59'),
(2, 5, 'update a user', '2020-05-31 16:49:10'),
(3, 6, 'add a user', '2020-05-31 16:49:34'),
(4, 6, 'update a user', '2020-05-31 16:50:49'),
(5, 7, 'add a user', '2020-05-31 16:54:59'),
(6, 7, 'update a user', '2020-05-31 16:55:12'),
(7, 8, 'add a user', '2020-05-31 21:07:53'),
(8, 9, 'add a user', '2020-05-31 21:27:32'),
(9, 10, 'add a user', '2020-05-31 21:35:38'),
(10, 9, 'update a user', '2020-05-31 21:37:11'),
(11, 10, 'update a user', '2020-05-31 21:37:27'),
(12, 9, 'add a user', '2020-06-04 09:03:33'),
(13, 10, 'add a user', '2020-06-04 09:04:52'),
(14, 11, 'add a user', '2020-06-04 09:07:07'),
(15, 11, 'update a user', '2020-06-04 09:08:17'),
(16, 8, 'update a user', '2020-06-04 09:08:42');

--
-- 限制导出的表
--

--
-- 限制表 `sc`
--
ALTER TABLE `sc`
  ADD CONSTRAINT `sc_ibfk_4` FOREIGN KEY (`Sno`) REFERENCES `selectcourse` (`Sno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sc_ibfk_5` FOREIGN KEY (`Sname`) REFERENCES `selectcourse` (`Sname`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sc_ibfk_6` FOREIGN KEY (`Cno`) REFERENCES `selectcourse` (`Cno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sc_ibfk_7` FOREIGN KEY (`Cname`) REFERENCES `selectcourse` (`Cname`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `selectcourse`
--
ALTER TABLE `selectcourse`
  ADD CONSTRAINT `selectcourse_ibfk_1` FOREIGN KEY (`Sno`) REFERENCES `student` (`Sno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `selectcourse_ibfk_2` FOREIGN KEY (`Cno`) REFERENCES `course` (`Cno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `selectcourse_ibfk_3` FOREIGN KEY (`Cname`) REFERENCES `course` (`Cname`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `selectcourse_ibfk_4` FOREIGN KEY (`Sname`) REFERENCES `student` (`Sname`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
