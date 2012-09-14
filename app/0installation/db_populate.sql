INSERT INTO `categories` (`id`, `parent_category_id`, `name`, `text`, `image`, `type`, `order`, `voice`, `voice_question`, `voice_answer`) VALUES
(1, 0, 'Use Computer', 'Do you want to use the computer?', 'eat6.jpg', 0, 1, '', '', ''),
(2, 0, 'Eat', 'Do you want to eat?', 'eat.jpg', 0, 2, '', '', ''),
(3, 0, 'Drink', 'Do you want to drink?', 'drink1.jpg', 0, 3, '', '', ''),
(4, 3, 'Open Drink', 'Open the drink bottle', 'opendrink.jpg', 1, 1, '', '', ''),
(5, 3, 'Pour drink', 'Pour drink', 'pourdrink.jpg', 1, 2, '', '', ''),
(6, 3, 'Close Drink', 'Close Drink', 'closedrink.jpg', 1, 4, '', '', ''),
(7, 3, 'Drink', 'Drink', 'drink.jpg', 1, 3, '', '', '');