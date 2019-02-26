-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.37-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

-- Dumping database structure for quiz
DROP DATABASE IF EXISTS `quiz`;
CREATE DATABASE IF NOT EXISTS `quiz` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `quiz`;

-- Dumping structure for table quiz.quiz
DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `ID` int(10) NOT NULL,
  `QUIZ_NAME` varchar(400) NOT NULL,
  `QUIZ_DATE` varchar(10) NOT NULL,
  `QUIZ_STATUS` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table quiz.quiz: ~2 rows (approximately)
INSERT INTO `quiz` (`ID`, `QUIZ_NAME`, `QUIZ_DATE`, `QUIZ_STATUS`) VALUES
	(1, 'QUIZ No.1', '20190225', 1),
	(2, 'QUIZ No.2', '20190225', 1);

-- Dumping structure for table quiz.quiz_answers
DROP TABLE IF EXISTS `quiz_answers`;
CREATE TABLE IF NOT EXISTS `quiz_answers` (
  `QUIZ_ID` int(10) NOT NULL,
  `QUIZ_QUESTION_ID` int(10) NOT NULL,
  `QUIZ_ANSWER_ID` int(10) NOT NULL,
  `QUIZ_CORECT_ANSWER` int(10) NOT NULL,
  `QUIZ_ANSWER` varchar(4000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table quiz.quiz_answers: ~28 rows (approximately)
INSERT INTO `quiz_answers` (`QUIZ_ID`, `QUIZ_QUESTION_ID`, `QUIZ_ANSWER_ID`, `QUIZ_CORECT_ANSWER`, `QUIZ_ANSWER`) VALUES
	(1, 1, 1, 0, '1.1. Question Answer 1'),
	(1, 1, 2, 1, '1.1. Question Answer 2'),
	(1, 2, 1, 0, '1.2. Question Answer 1'),
	(1, 2, 2, 0, '1.2. Question Answer 2'),
	(1, 2, 3, 0, '1.2. Question Answer 3'),
	(1, 2, 4, 0, '1.2. Question Answer 4'),
	(1, 2, 5, 0, '1.2. Question Answer 5'),
	(1, 2, 6, 0, '1.2. Question Answer 6'),
	(1, 2, 7, 0, '1.2. Question Answer 7'),
	(1, 2, 8, 1, '1.2. Question Answer 8'),
	(1, 2, 9, 0, '1.2. Question Answer 9'),
	(1, 2, 10, 0, '1.2. Question Answer 10'),
	(1, 2, 11, 0, '1.2. Question Answer 11'),
	(1, 3, 1, 1, '1.3. Question Answer 1'),
	(1, 3, 2, 0, '1.3. Question Answer 2'),
	(1, 3, 3, 0, '1.3. Question Answer 3'),
	(2, 1, 1, 0, '2.1. Question Answer 1'),
	(2, 1, 2, 1, '2.1. Question Answer 2'),
	(2, 1, 3, 0, '2.1. Question Answer 3'),
	(2, 1, 4, 0, '2.1. Question Answer 4'),
	(2, 2, 1, 0, '2.2. Question Answer 1'),
	(2, 2, 2, 0, '2.2. Question Answer 2'),
	(2, 2, 3, 0, '2.2. Question Answer 3'),
	(2, 2, 4, 0, '2.2. Question Answer 4'),
	(2, 2, 5, 1, '2.2. Question Answer 5'),
	(2, 3, 1, 0, '2.3. Question Answer 1'),
	(2, 3, 2, 0, '2.3. Question Answer 2'),
	(2, 3, 3, 1, '2.3. Question Answer 3');


-- Dumping structure for table quiz.quiz_question
DROP TABLE IF EXISTS `quiz_question`;
CREATE TABLE IF NOT EXISTS `quiz_question` (
  `QUIZ_ID` int(10) NOT NULL,
  `QUIZ_QUESTION_ID` int(10) NOT NULL,
  `QUIZ_QUESTIONS` varchar(4000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table quiz.quiz_question: ~6 rows (approximately)
INSERT INTO `quiz_question` (`QUIZ_ID`, `QUIZ_QUESTION_ID`, `QUIZ_QUESTIONS`) VALUES
	(1, 1, '1. QUIZ Question No.1'),
	(1, 2, '1. QUIZ Question No.2'),
	(1, 3, '1. QUIZ Question No.3'),
	(2, 1, '2. QUIZ Question No.1'),
	(2, 2, '2. QUIZ Question No.2'),
	(2, 3, '2. QUIZ Question No.3');

-- Dumping structure for table quiz.quiz_responses
DROP TABLE IF EXISTS `quiz_responses`;
CREATE TABLE IF NOT EXISTS `quiz_responses` (
  `QUIZ_RESPONSE_ID` varchar(50) NOT NULL,
  `QUIZ_RESPONSE_USER` varchar(150) NOT NULL,
  `QUIZ_ID` int(10) NOT NULL,
  `QUIZ_QUESTOON_ID` int(10) NOT NULL,
  `QUIZ_GIVEN_ANSWER_ID` int(10) NOT NULL,
  `QUIZ_ANSWER_CORRECT` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table quiz.quiz_responses: ~0 rows (approximately)

-- Dumping structure for table quiz.quiz_results
DROP TABLE IF EXISTS `quiz_results`;
CREATE TABLE IF NOT EXISTS `quiz_results` (
  `attempt_id` varchar(50) NOT NULL,
  `quiz_id` int(50) NOT NULL,
  `user` varchar(150) NOT NULL,
  `correct_answers` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table quiz.quiz_results: ~0 rows (approximately)
