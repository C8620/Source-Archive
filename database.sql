SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `common` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `strike` smallint(11) DEFAULT NULL,
  `tower` smallint(11) DEFAULT NULL,
  `love` smallint(11) DEFAULT NULL,
  `vow` smallint(11) DEFAULT NULL,
  `ex` smallint(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `entry` (
  `id` int(11) NOT NULL,
  `common` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `strike` smallint(6) DEFAULT NULL,
  `tower` smallint(6) DEFAULT NULL,
  `love` smallint(6) DEFAULT NULL,
  `vow` smallint(6) DEFAULT NULL,
  `ex` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tblAuthSessions` (
  `intAuthID` int(11) NOT NULL,
  `txtSessionKey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtExpires` datetime DEFAULT NULL,
  `txtRedir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txtRefreshToken` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txtCodeVerifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txtToken` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txtIDToken` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `strike` (`strike`),
  ADD UNIQUE KEY `tower` (`tower`),
  ADD UNIQUE KEY `love` (`love`),
  ADD UNIQUE KEY `vow` (`vow`),
  ADD UNIQUE KEY `ex` (`ex`),
  ADD UNIQUE KEY `common` (`common`,`strike`,`tower`,`love`,`vow`,`ex`) USING HASH;

ALTER TABLE `entry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `filename` (`filename`) USING HASH,
  ADD UNIQUE KEY `common` (`common`) USING HASH;

ALTER TABLE `tblAuthSessions`
  ADD PRIMARY KEY (`intAuthID`);

ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

ALTER TABLE `entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2111;

ALTER TABLE `tblAuthSessions`
  MODIFY `intAuthID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4872;
COMMIT;