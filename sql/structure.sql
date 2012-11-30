CREATE TABLE `arguments` (
  `argumentId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `parentId` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `userId` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `headline` varchar(100) NOT NULL,
  `abstract` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `dateAdded` bigint(20) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`argumentId`),
  UNIQUE KEY `questionId` (`questionId`,`parentId`,`url`),
  KEY `userId` (`userId`,`questionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `badwords` (
  `badwordId` int(11) NOT NULL,
  `category` tinyint(4) NOT NULL,
  `word` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `confirmation_codes` (
  `confirmationId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `code` varchar(128) NOT NULL,
  `dateAdded` int(13) NOT NULL,
  PRIMARY KEY (`confirmationId`),
  UNIQUE KEY `userId` (`userId`,`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `localization` (
  `loc_key` varchar(255) NOT NULL,
  `loc_language` varchar(4) NOT NULL,
  `loc_val` text NOT NULL,
  PRIMARY KEY (`loc_key`),
  KEY `loc_language` (`loc_language`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `pages` (
  `pageId` int(11) NOT NULL AUTO_INCREMENT,
  `pageTitle` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `className` varchar(100) NOT NULL,
  `templateFile` varchar(100) NOT NULL,
  PRIMARY KEY (`pageId`),
  UNIQUE KEY `pageTitle` (`pageTitle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `permissions` (
  `permissionId` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY (`permissionId`),
  UNIQUE KEY `groupId` (`groupId`,`action`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `questions` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `dateAdded` bigint(20) NOT NULL,
  `userId` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `scoreTrending` int(11) NOT NULL,
  `scoreTop` int(11) NOT NULL,
  `additionalData` text NOT NULL,
  PRIMARY KEY (`questionId`),
  UNIQUE KEY `url` (`url`),
  KEY `score` (`score`),
  KEY `scoreTrending` (`scoreTrending`),
  KEY `scoreTop` (`scoreTop`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `sessions` (
  `sessionId` varchar(32) NOT NULL,
  `sessionData` text NOT NULL,
  `sessionDate` int(11) NOT NULL,
  PRIMARY KEY (`sessionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `tags` (
  `tagId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL,
  PRIMARY KEY (`tagId`),
  KEY `tag` (`tag`,`questionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `group` int(11) NOT NULL,
  `password` varchar(256) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `dateAdded` bigint(20) NOT NULL,
  `user_last_action` bigint(20) NOT NULL,
  `scoreQuestions` int(11) NOT NULL,
  `scoreArguments` int(11) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userName` (`userName`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `user_factions` (
  `factionId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY (`factionId`),
  UNIQUE KEY `userId` (`userId`,`questionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `user_votes` (
  `voteId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  `argumentId` int(11) NOT NULL,
  `vote` int(4) NOT NULL,
  `dateAdded` bigint(20) NOT NULL,
  PRIMARY KEY (`voteId`),
  UNIQUE KEY `userId` (`userId`,`questionId`,`argumentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
