# ZAPPKA_CODE

SQL:
```sql 
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `kody` (
  `id` int NOT NULL,
  `kod` bigint NOT NULL,
  `informacja` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pozostało` int NOT NULL DEFAULT '2',
  `ostatnieuzycie` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

ALTER TABLE `kody`
  ADD PRIMARY KEY (`id`);
```