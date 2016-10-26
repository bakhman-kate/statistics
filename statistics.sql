-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 26 2016 г., 14:34
-- Версия сервера: 10.1.8-MariaDB
-- Версия PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `statistics`
--

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created` datetime DEFAULT NULL,
  `status` enum('new','registered','refused','unavailable') NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id`, `name`, `surname`, `phone`, `created`, `status`) VALUES
(1, 'Ivan', 'Ivanov', '+7(999)999-99-99', '2016-06-01 10:00:00', 'new'),
(2, 'Petr', 'Petrov', '+7(8442)36-36-36', '2016-10-02 14:04:00', 'registered'),
(3, 'Vasilina', 'Komkova', '+7(495)111-11-11', '2016-09-04 00:12:00', 'refused'),
(4, 'Olga', 'Albenova', '+7(987)321-32-00', '2016-07-17 05:00:00', 'unavailable'),
(5, 'Elena', 'Kikvidze', '+7(914)321-32-00', '2016-10-09 20:00:00', 'new'),
(6, 'Maxim', 'Potashev', '+7(914)321-32-01', '2016-07-07 00:00:00', 'registered'),
(7, 'Artem', 'Pivovarov', '+7(999)766-77-34', '2016-06-15 00:00:00', 'registered'),
(8, 'Alina', 'Kopilova', '45-45-90', '2016-10-04 00:00:00', 'registered'),
(9, 'Marina', 'Emelianova', '567890', '2016-09-13 00:00:00', 'registered'),
(10, 'Albina', 'Nagucheva', '67-78-34', '2016-08-18 00:00:00', 'registered'),
(11, 'Andrew', 'Timofeev', '678876', '2016-09-21 00:00:00', 'registered'),
(12, 'Sergey', 'Martynenko', '6787845', '2016-09-15 00:00:00', 'registered');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1477408048),
('m161025_145716_create_client_table', 1477421016);

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `amount` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `datetime`, `amount`) VALUES
(1, 5, '2016-10-02 00:00:00', 5000),
(2, 1, '2016-10-07 00:00:00', 1000),
(3, 5, '2016-10-19 00:00:00', 2100),
(4, 2, '2016-10-01 00:00:00', 18000),
(5, 2, '2016-10-08 00:00:00', 5000),
(6, 3, '2016-10-04 00:00:00', 500),
(7, 1, '2016-10-14 00:00:00', 4000),
(8, 2, '2016-10-13 00:00:00', 18000),
(9, 1, '2016-10-04 00:00:00', 0),
(10, 1, '2016-10-12 00:00:00', 4000),
(11, 2, '2016-10-12 00:00:00', 5000);

-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL DEFAULT '',
  `gender` enum('male','female','unknown') DEFAULT 'unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student`
--

INSERT INTO `student` (`id`, `name`, `surname`, `gender`) VALUES
(1, 'Елизавета', 'Образцова', 'female'),
(2, 'Дмитрий', 'Сидоров', 'male'),
(3, 'Иван', 'Иванов', 'unknown'),
(4, 'Петро', 'Петров', 'unknown'),
(5, 'Василиса', 'Прекрасная', 'unknown'),
(6, 'Елена', 'Премудрая', 'unknown');

-- --------------------------------------------------------

--
-- Структура таблицы `student_status`
--

CREATE TABLE `student_status` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('new','studying','vacation','testing','lost') NOT NULL DEFAULT 'new',
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student_status`
--

INSERT INTO `student_status` (`id`, `student_id`, `status`, `datetime`) VALUES
(1, 1, 'new', '2016-10-03 00:00:00'),
(2, 2, 'new', '2016-10-09 00:00:00'),
(3, 3, 'new', '2016-10-01 00:00:00'),
(4, 4, 'new', '2016-10-09 00:00:00'),
(5, 5, 'new', '2016-10-02 00:00:00'),
(6, 6, 'new', '2016-10-02 00:00:00'),
(7, 3, 'studying', '2016-10-23 00:00:00'),
(8, 4, 'testing', '2016-10-19 00:00:00'),
(9, 3, 'vacation', '2016-10-24 00:00:00'),
(10, 5, 'lost', '2016-10-24 00:00:00'),
(11, 3, 'lost', '2016-10-25 00:00:00');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Индексы таблицы `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gender` (`gender`);

--
-- Индексы таблицы `student_status`
--
ALTER TABLE `student_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `datetime` (`datetime`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `student_status`
--
ALTER TABLE `student_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
