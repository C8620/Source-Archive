SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `categoryType` char(64) NOT NULL,
  `categoryTypeID` int(11) NOT NULL,
  `categoryCommon_zh` text DEFAULT NULL,
  `categoryCommon_en` text DEFAULT NULL,
  `categoryCommon_ja` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `displayType` (
  `id` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `entry` (
  `entryID` int(11) NOT NULL,
  `entryCommon_zh` text DEFAULT NULL,
  `entryCommon_en` text DEFAULT NULL,
  `entryCommon_ja` text DEFAULT NULL,
  `entryPath` text NOT NULL,
  `entryForm` tinyint(4) NOT NULL DEFAULT 0,
  `entryTypeName` char(64) NOT NULL,
  `entryTypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `ipdata` (
  `ip` varchar(64) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tblAuthSessions` (
  `intAuthID` int(11) NOT NULL,
  `txtSessionKey` varchar(255) DEFAULT NULL,
  `dtExpires` datetime DEFAULT NULL,
  `txtRedir` varchar(255) DEFAULT NULL,
  `txtRefreshToken` text DEFAULT NULL,
  `txtCodeVerifier` varchar(255) DEFAULT NULL,
  `txtToken` text DEFAULT NULL,
  `txtIDToken` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `type` (
  `typeName` char(64) NOT NULL,
  `typeCommon_zh` text DEFAULT NULL,
  `typeCommon_en` text DEFAULT NULL,
  `typeCommon_ja` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`),
  ADD KEY `type_category` (`categoryType`);

ALTER TABLE `displayType`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `entry`
  ADD PRIMARY KEY (`entryID`),
  ADD KEY `dtype_entry` (`entryForm`),
  ADD KEY `type_entry` (`entryTypeName`);

ALTER TABLE `ipdata`
  ADD PRIMARY KEY (`ip`),
  ADD UNIQUE KEY `ip` (`ip`);

ALTER TABLE `tblAuthSessions`
  ADD PRIMARY KEY (`intAuthID`);

ALTER TABLE `type`
  ADD PRIMARY KEY (`typeName`);

ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

ALTER TABLE `entry`
  MODIFY `entryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5016;

ALTER TABLE `tblAuthSessions`
  MODIFY `intAuthID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3346;

ALTER TABLE `category`
  ADD CONSTRAINT `type_category` FOREIGN KEY (`categoryType`) REFERENCES `type` (`typeName`) ON UPDATE CASCADE;

ALTER TABLE `entry`
  ADD CONSTRAINT `dtype_entry` FOREIGN KEY (`entryForm`) REFERENCES `displayType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `type_entry` FOREIGN KEY (`entryTypeName`) REFERENCES `type` (`typeName`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;