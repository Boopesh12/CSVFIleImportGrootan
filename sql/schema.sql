

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userId` int(8) NOT NULL,
  `item` varchar(55) NOT NULL,
  `statusitem` varchar(55) NOT NULL,
  `region` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;