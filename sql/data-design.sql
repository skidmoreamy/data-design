

-- this is a comment in SQL (yes, the space is needed!)
-- these statements will drop the tables and re-add them
-- this is akin to reformatting and reinstalling Windows (OS X never needs a reinstall...) ;)
-- never ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever
-- do this on live data!!!!
DROP TABLE IF EXISTS `favorite`;
DROP TABLE IF EXISTS shop;
DROP TABLE IF EXISTS profile;

-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema
CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- auto_increment tells mySQL to number them {1, 2, 3, ...}
	-- not null means the attribute is required!
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profileHash	CHAR(128) NOT NULL,
	-- to make something optional, exclude the not null
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);

-- create the shop entity
CREATE TABLE shop (
	-- this is for yet another primary key...
	shopId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	-- this is for a foreign key; auto_incremented is omitted by design
	shopName INT UNSIGNED NOT NULL,
	shopContent VARCHAR(140) NOT NULL,
	-- Enter you date if you have one in this class, here, and this way;Date DATETIME(6) NOT NULL,
	-- this creates an index before making a foreign key
	INDEX(shopName),
	-- this creates the actual foreign key relation
	FOREIGN KEY(shopName) REFERENCES profile(profileId),
	-- and finally create the primary key
	PRIMARY KEY(shopId)
);

-- create the like entity (a weak entity from an m-to-n for profile --> tweet)
CREATE TABLE `favorite` (
	-- these are not auto_increment because they're still foreign keys
	favoriteProfileId INT UNSIGNED NOT NULL,
	favoriteShopId INT UNSIGNED NOT NULL,
	favoriteDate DATETIME(6) NOT NULL,
	-- index the foreign keys
	INDEX(favoriteProfileId),
	INDEX(favoriteShopId),
	-- create the foreign key relations
	FOREIGN KEY(favoriteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(favoriteShopId) REFERENCES shop(shopId),
	-- finally, create a composite foreign key with the two foreign keys
	PRIMARY KEY(favoriteProfileId, favoriteShopId)
);