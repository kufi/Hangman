
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- words
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `words`;


CREATE TABLE `words`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`word` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `words_U_1` (`word`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- player
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `player`;


CREATE TABLE `player`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`last_update` DATETIME  NOT NULL,
	`in_lobby` TINYINT default 1 NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `player_U_1` (`name`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- games
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `games`;


CREATE TABLE `games`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`player1_id` INTEGER  NOT NULL,
	`player2_id` INTEGER,
	`word_id` INTEGER  NOT NULL,
	`player_turn` INTEGER default 1 NOT NULL,
	`player1_faults` INTEGER default 0,
	`player2_faults` INTEGER default 0,
	`used_letters` VARCHAR(500),
	`new_game_player1` TINYINT default 0,
	`new_game_player2` TINYINT default 0,
	`new_game_started` TINYINT default 0,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `games_FI_1` (`player1_id`),
	CONSTRAINT `games_FK_1`
		FOREIGN KEY (`player1_id`)
		REFERENCES `player` (`id`)
		ON DELETE CASCADE,
	INDEX `games_FI_2` (`player2_id`),
	CONSTRAINT `games_FK_2`
		FOREIGN KEY (`player2_id`)
		REFERENCES `player` (`id`)
		ON DELETE CASCADE,
	INDEX `games_FI_3` (`word_id`),
	CONSTRAINT `games_FK_3`
		FOREIGN KEY (`word_id`)
		REFERENCES `words` (`id`)
)Engine=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
