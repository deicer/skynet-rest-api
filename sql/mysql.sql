--
-- ��������� ������� `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
                            `ID` int(11) NOT NULL,
                            `user_id` int(11) NOT NULL,
                            `tarif_id` int(11) NOT NULL,
                            `payday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- ��������� ������� `tarifs`
--

DROP TABLE IF EXISTS `tarifs`;
CREATE TABLE `tarifs` (
                          `ID` int(11) NOT NULL,
                          `title` varchar(255) NOT NULL,
                          `price` decimal(15,4) NOT NULL,
                          `link` varchar(255) NOT NULL,
                          `speed` int(11) NOT NULL,
                          `pay_period` int(11) NOT NULL,
                          `tarif_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- ��������� ������� `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `ID` int(11) NOT NULL,
                         `login` char(12) NOT NULL,
                         `name_last` varchar(255) NOT NULL,
                         `name_first` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- ������� ���������� ������
--

--
-- ������� ������� `services`
--
ALTER TABLE `services`
    ADD PRIMARY KEY (`ID`);

--
-- ������� ������� `tarifs`
--
ALTER TABLE `tarifs`
    ADD PRIMARY KEY (`ID`);

--
-- ������� ������� `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT ��� ���������� ������
--

--
-- AUTO_INCREMENT ��� ������� `services`
--
ALTER TABLE `services`
    MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT ��� ������� `tarifs`
--
ALTER TABLE `tarifs`
    MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT ��� ������� `users`
--
ALTER TABLE `users`
    MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- ���� ������ ������� `services`
--

INSERT INTO `services` (`ID`, `user_id`, `tarif_id`, `payday`) VALUES
(1, 1, 1, '2018-12-06'),
(2, 2, 3, '2018-12-06');

--
-- ���� ������ ������� `tarifs`
--

INSERT INTO `tarifs` (`ID`, `title`, `price`, `link`, `speed`, `pay_period`, `tarif_group_id`) VALUES
(1, '�����', 500, 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 1, 1),
(2, '����� (3 ���)', 1350, 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 1, 1),
(3, '����� (12 ���)', 4200, 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 1, 1),
(4, '����', 600, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 3, 3),
(5, '���� (3 ���)', 1650, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 3, 3),
(6, '���� (12 ���)', 5400, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 3, 3);

--
-- ���� ������ ������� `users`
--

INSERT INTO `users` (`ID`, `login`, `name_last`, `name_first`) VALUES
(1, 'test1', '������', '�������'),
(2, 'test2', '��������', 'ϸ��');
