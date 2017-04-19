
DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS shop;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR(32) NOT NULL,
	profileEmail VARCHAR (128) UNIQUE NOT NULL,
	profileHash CHAR (128) NOT NULL,
	profilePhone VARCHAR (32),
	profileSalt CHAR (64),
	PRIMARY KEY (profileId)
);
CREATE TABLE shop (
	shopId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	shopContent VARCHAR (140) NOT NULL,
	shopName VARCHAR (32) NOT NULL,
	INDEX (shopId),
	PRIMARY KEY (shopId)
);
CREATE TABLE favorite (
	favoriteProfileId INT UNSIGNED NOT NULL,
	favoriteDate DATETIME NOT NULL,
	favoriteShopId INT UNSIGNED NOT NULL,
	INDEX (favoriteProfileId),
	FOREIGN KEY (favoriteProfileId) REFERENCES profile (profileId),
	FOREIGN KEY (favoriteShopId) REFERENCES shop (shopId),
	PRIMARY KEY (favoriteProfileId, favoriteShopId)
);
