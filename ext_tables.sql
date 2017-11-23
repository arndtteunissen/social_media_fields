CREATE TABLE pages (
	tx_socialmediafields_opengraph_headline varchar(150) DEFAULT '' NOT NULL,
	tx_socialmediafields_opengraph_description tinytext,
	tx_socialmediafields_opengraph_images int(11) unsigned DEFAULT '0' NOT NULL,

	tx_socialmediafields_twitter_headline varchar(150) DEFAULT '' NOT NULL,
	tx_socialmediafields_twitter_description tinytext,
	tx_socialmediafields_twitter_images int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE pages_language_overlay (
	tx_socialmediafields_opengraph_headline varchar(150) DEFAULT '' NOT NULL,
	tx_socialmediafields_opengraph_description tinytext,
	tx_socialmediafields_opengraph_images int(11) unsigned DEFAULT '0' NOT NULL,

	tx_socialmediafields_twitter_headline varchar(150) DEFAULT '' NOT NULL,
	tx_socialmediafields_twitter_description tinytext,
	tx_socialmediafields_twitter_images int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_news_domain_model_news (
	tx_socialmediafields_opengraph_headline varchar(150) DEFAULT '' NOT NULL,
	tx_socialmediafields_opengraph_description tinytext,
	tx_socialmediafields_opengraph_images int(11) unsigned DEFAULT '0' NOT NULL,

	tx_socialmediafields_twitter_headline varchar(150) DEFAULT '' NOT NULL,
	tx_socialmediafields_twitter_description tinytext,
	tx_socialmediafields_twitter_images int(11) unsigned DEFAULT '0' NOT NULL
);