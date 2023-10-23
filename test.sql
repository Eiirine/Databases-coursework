-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 13 2023 г., 07:47
-- Версия сервера: 8.0.34
-- Версия PHP: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `text` text NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `text`, `comment_date`, `user_id`, `post_id`) VALUES
(1, 'Count me in', '2023-10-12 12:51:32', 1, 6),
(2, 'What sort of help?', '2023-10-12 12:51:32', 5, 3),
(3, 'Congrats buddy', '2023-10-12 12:51:32', 2, 4),
(4, 'I was rooting for Nadal though', '2023-10-12 12:51:32', 4, 5),
(5, 'Help with your thesis?', '2023-10-12 12:51:32', 2, 3),
(6, 'Many congratulations', '2023-10-12 12:51:32', 5, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(1, 1, 6),
(2, 2, 3),
(3, 1, 5),
(4, 5, 4),
(5, 2, 4),
(6, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `post_date`, `title`, `description`, `user_id`) VALUES
(1, '2023-10-11 14:08:10', 'Погрузитесь в мир истории с этими удивительными книгами!', 'Устали от однообразных книг и фильмов о современном мире? Хотите узнать больше об истории человечества и его культурном наследии? Тогда эти удивительные книги для вас! От древних цивилизаций до мировых войн, от захватывающих приключений до глубоких философских размышлений – здесь вы найдете книги на любой вкус. Погрузитесь в увлекательный мир истории, и вы не сможете остановиться.', 1),
(2, '2023-10-11 14:08:10', 'Вы никогда не задумывались о том, как музыка влияет на нас?', 'Знаете ли вы, что музыка может улучшить наше настроение, снизить уровень стресса и даже повысить производительность? Она также может помочь нам лучше понимать друг друга и развивать эмпатию. Так что, не стесняйтесь выражать себя через музыку, ведь она способна изменить вашу жизнь к лучшему!', 2),
(3, '2023-10-11 14:08:10', 'Хотите стать лучшей версией себя? Начните с малого!', 'Многие люди мечтают о грандиозных переменах, но не знают, с чего начать. Не беспокойтесь! Даже маленькие шаги могут привести к большим результатам. Просто начните делать то, что вам нравится, и постепенно расширяйте свои горизонты. Помните, что главное – это постоянство и упорство. И не забывайте радоваться своим маленьким успехам!', 2),
(4, '2023-10-11 14:08:10', 'Искусство быть счастливым: как найти свое место в жизни', 'Каждый из нас мечтает о счастье, но мало кто знает, как достичь его. В этой статье мы поговорим о том, что делает нас счастливыми и как найти свой путь в жизни. Вы узнаете о важности саморазвития, общения с близкими и умения радоваться мелочам. Следуя этим простым советам, вы сможете стать счастливее и наслаждаться каждым моментом своей жизни!', 1),
(5, '2023-10-11 14:08:10', 'Открываем новые таланты: бесплатные онлайн-курсы для начинающих', 'Мечтаете научиться рисовать, программировать или говорить на иностранном языке? У нас отличные новости! Теперь вы можете делать это, не выходя из дома, благодаря бесплатным онлайн-курсам. Здесь каждый найдет что-то по душе - от базовых навыков до профессионального уровня. Присоединитесь к тысячам людей, которые уже изменили свою жизнь благодаря онлайн-обучению!', 5),
(6, '2023-10-11 14:08:10', 'Готовим дома: простые и полезные рецепты для всей семьи', 'Устали от фаст-фуда и хотите разнообразить свой рацион? Попробуйте приготовить эти простые и полезные блюда дома! Мы собрали для вас рецепты, которые подойдут как новичкам, так и опытным кулинарам. От легких салатов до сытных супов, от десертов до основных блюд - здесь вы найдете всё, чтобы порадовать себя и своих близких.', 3),
(14, '2023-10-12 11:11:43', 'тест', '111', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `reposts`
--

CREATE TABLE `reposts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `reposts`
--

INSERT INTO `reposts` (`id`, `user_id`, `post_id`) VALUES
(1, 1, 6),
(2, 2, 3),
(3, 1, 5),
(4, 5, 4),
(5, 2, 4),
(6, 4, 2),
(7, 3, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `age` int DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `age`, `gender`) VALUES
(1, 'Астарион', 39, 1),
(2, 'Лаэзель', 18, 0),
(3, 'Карлах', 28, 0),
(4, 'Гейл', 40, 1),
(5, 'Шэдоухарт', 24, 0),
(6, 'Уилл', 41, 1),
(7, 'Тав', 23, 0),
(17, 'Ирина', 22, 0),
(20, 'Максим', 18, 1),
(21, 'Ирина', 34, 0),
(22, 'Марина', 21, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `reposts`
--
ALTER TABLE `reposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `reposts`
--
ALTER TABLE `reposts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `reposts`
--
ALTER TABLE `reposts`
  ADD CONSTRAINT `reposts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reposts_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
