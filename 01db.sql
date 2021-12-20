CREATE TABLE `clocker`.`User` (
`id` INT NOT NULL AUTO_INCREMENT ,
`username` VARCHAR( 50 ) NOT NULL ,
`email` VARCHAR( 50 ) NOT NULL ,
`password` VARCHAR( 2048 ) NOT NULL ,
`role` VARCHAR( 25 ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;

CREATE TABLE `clocker`.`Task` (
`id` INT NOT NULL AUTO_INCREMENT ,
`userId` INT NOT NULL ,
`projectId` INT,
`title` VARCHAR( 200 ) NOT NULL ,
`startTime` DATETIME NOT NULL ,
`stopTime` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;
ALTER TABLE `Task` ADD INDEX ( `userId` );
ALTER TABLE `Task` ADD INDEX ( `projectId` );
ALTER TABLE `Task` ADD FOREIGN KEY ( `userId` ) REFERENCES `clocker`.`User` (
`id`
);

ALTER TABLE `Task` ADD FOREIGN KEY ( `projectId` ) REFERENCES `clocker`.`Project` (
`id`
);


CREATE TABLE `clocker`.`Project` (
`id` INT NOT NULL AUTO_INCREMENT ,
`userId` INT NOT NULL ,
`clientId` INT NULL ,
`wage` DECIMAL( 10, 2 ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;
ALTER TABLE `Project` ADD `projectName` VARCHAR( 50 ) CHARACTER SET utf32 COLLATE utf32_general_ci NOT NULL AFTER `clientId`
ALTER TABLE `Project` ADD INDEX ( `userId` );
ALTER TABLE `Project` ADD INDEX ( `clientId` );
ALTER TABLE `Project` ADD FOREIGN KEY ( `userId` ) REFERENCES `clocker`.`User` (
`id`
);

ALTER TABLE `Project` ADD FOREIGN KEY ( `clientId` ) REFERENCES `clocker`.`Client` (
`id`
);


CREATE TABLE `clocker`.`Client` (
`id` INT NOT NULL ,
`userId` INT NOT NULL ,
`clientName` VARCHAR( 50 ) NOT NULL
) ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;
ALTER TABLE `Client` ADD PRIMARY KEY ( `id` )
ALTER TABLE `Client` ADD INDEX ( `userId` )
ALTER TABLE `Client` ADD FOREIGN KEY ( `userId` ) REFERENCES `clocker`.`User` (
`id`
);
