CREATE DATABASE IF NOT EXISTS `GoodbenUser` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;


CREATE TABLE `User` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `phoneNumber` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `userId` varchar(10) NOT NULL, 
  `dateCreat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateLastConnexion` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 


INSERT INTO `User` (`name`, `middleName`, `firstName`, `phoneNumber`, `password`, `role`, `pays`) VALUES
('LUKUSA', 'MUKENA', 'Gauthier', '0903004900', '$2y$10$vw8SZtNC1ZZyh6Uwd1sio.VSspmALBYXKhW1XFeNOd8mRIKG1EE7m', 'Operateur', 'ROYAUME DU MAROC');
