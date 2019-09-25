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
-- 資料庫： `class`
--

-- --------------------------------------------------------

--
-- 資料表結構 `scorelist`
--

CREATE TABLE `scorelist` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `cID` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `course` enum('國文','英文','數學') COLLATE utf8_unicode_ci DEFAULT '國文',
  `score` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `scorelist`
--

INSERT INTO `scorelist` (`id`, `cID`, `course`, `score`) VALUES
(1, 01, '國文', 82),
(2, 02, '國文', 68),
(3, 03, '國文', 78),
(4, 04, '國文', 85),
(5, 05, '國文', 80),
(6, 06, '國文', 76),
(7, 07, '國文', 90),
(8, 08, '國文', 87),
(9, 09, '國文', 78),
(10, 10, '國文', 65),
(11, 01, '英文', 67),
(12, 02, '英文', 87),
(13, 03, '英文', 88),
(14, 04, '英文', 92),
(15, 05, '英文', 55),
(16, 06, '英文', 62),
(17, 07, '英文', 65),
(18, 08, '英文', 40),
(19, 09, '英文', 89),
(20, 10, '英文', 64),
(21, 01, '數學', 87),
(22, 02, '數學', 52),
(23, 03, '數學', 76),
(24, 04, '數學', 56),
(25, 05, '數學', 72),
(26, 06, '數學', 80),
(27, 07, '數學', 38),
(28, 08, '數學', 68),
(29, 09, '數學', 90),
(30, 10, '數學', 61);

-- --------------------------------------------------------

--
-- 資料表結構 `students`
--

CREATE TABLE `students` (
  `cID` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `cName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cSex` enum('M','F') COLLATE utf8_unicode_ci NOT NULL,
  `cBirthday` date NOT NULL,
  `cEmail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cPhone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cAddr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cHeight` tinyint(3) UNSIGNED DEFAULT NULL,
  `cWeight` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `students`
--

INSERT INTO `students` (`cID`, `cName`, `cSex`, `cBirthday`, `cEmail`, `cPhone`, `cAddr`, `cHeight`, `cWeight`) VALUES
(01, '孫源源', 'F', '1987-04-04', 'elven@superstar.com', '0922988876', '台北市濟州北路12號', 160, 49),
(02, '彭建志', 'M', '1987-07-01', 'jinglun@superstar.com', '0918181111', '台北市敦化南路93號5樓', 175, 72),
(03, '謝耿弘', 'M', '1987-08-11', 'sugie@superstar.com', '0914530768', '台北市中央路201號7樓', 162, 65),
(04, '蔣志明', 'M', '1984-06-20', 'shane@superstar.com', '0946820035', '台北市建國路177號6樓', 178, 72),
(05, '王珮珊', 'F', '1988-02-15', 'ivy@superstar.com', '0920981230', '台北市忠孝東路520號6樓', 164, 45),
(06, '林志宇', 'M', '1987-05-05', 'zhong@superstar.com', '0951983366', '台北市民生路1巷10號', 172, 75),
(07, '李曉薇', 'F', '1985-08-30', 'lala@superstar.com', '0918123456', '台北市仁愛路100號', 158, 56),
(08, '賴秀英', 'F', '1986-12-10', 'crystal@superstar.com', '0907408965', '台北市民族路204號', 166, 48),
(09, '張雅琪', 'F', '1988-12-01', 'peggy@superstar.com', '0916456723', '台北市建國北路10號', 168, 50),
(10, '許朝元', 'M', '1993-08-10', 'albert@superstar.com', '0918976588', '台北市新生南路85號', 169, 68),
(11, '李伯恩', 'M', '1981-06-15', 'born@superstar.com', '0929011234', '台中市美村南路12號', 174, 92);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `scorelist`
--
ALTER TABLE `scorelist`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`cID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `students`
--
ALTER TABLE `students`
  MODIFY `cID` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
