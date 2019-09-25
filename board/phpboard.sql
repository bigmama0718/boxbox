-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 
-- 伺服器版本： 10.4.6-MariaDB
-- PHP 版本： 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `phpboard`
--

-- --------------------------------------------------------

--
-- 資料表結構 `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `admin`
--

INSERT INTO `admin` (`username`, `passwd`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- 資料表結構 `board`
--

CREATE TABLE `board` (
  `boardid` int(11) UNSIGNED NOT NULL,
  `boardname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardsex` enum('男','女') COLLATE utf8_unicode_ci DEFAULT '男',
  `boardsubject` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardtime` datetime DEFAULT NULL,
  `boardmail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardweb` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardcontent` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `board`
--

INSERT INTO `board` (`boardid`, `boardname`, `boardsex`, `boardsubject`, `boardtime`, `boardmail`, `boardweb`, `boardcontent`) VALUES
(1, '莫宰羊', '男', '123', '2019-09-22 16:49:11', '', '', 'hello world'),
(2, '莫宰羊', '男', '123', '2019-09-22 16:49:34', '', '', 'hello world'),
(3, '莫宰羊', '男', '123', '2019-09-22 16:49:48', '', '', 'hello world'),
(4, '王曉明', '男', '789', '2019-09-22 16:52:01', '', '', 'hellooooooo'),
(5, '曉華', '男', '456', '2019-09-22 17:03:38', 'ggg@gmail.com', '', 'hihi'),
(6, '黃小姐', '女', 'abc', '2019-09-22 17:15:27', 'aaa@gmail.com', '', 'wellwellwell'),
(7, '黃小姐', '女', 'abc', '2019-09-22 17:18:39', 'aaa@gmail.com', 'http://www.google.com.tw', '123');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`boardid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `board`
--
ALTER TABLE `board`
  MODIFY `boardid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
