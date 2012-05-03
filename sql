//jeremy, 2 mai
ALTER TABLE `BadgeGagne` DROP PRIMARY KEY;

//jeremy, 3 mai

CREATE TABLE `Statut` (
`id` INT( 11 ) NOT NULL ,
`nom` VARCHAR( 255 ) NOT NULL ,
`icone` VARCHAR( 255 ) NOT NULL ,
`nb_points` INT( 11 ) NOT NULL
) ENGINE = InnoDB;
ALTER TABLE `Statut` ADD PRIMARY KEY(`id`);
ALTER TABLE `Statut` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT ;



