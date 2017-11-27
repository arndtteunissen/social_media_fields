CREATE TABLE pages (
    tx_socialmediafields_opengraph_headline VARCHAR(150) DEFAULT '' NOT NULL,
    tx_socialmediafields_opengraph_description TINYTEXT,
    tx_socialmediafields_opengraph_images INT(11) UNSIGNED DEFAULT '0' NOT NULL,

    tx_socialmediafields_twitter_headline VARCHAR(150) DEFAULT '' NOT NULL,
    tx_socialmediafields_twitter_description TINYTEXT,
    tx_socialmediafields_twitter_images INT(11) UNSIGNED DEFAULT '0' NOT NULL
);

CREATE TABLE pages_language_overlay (
    tx_socialmediafields_opengraph_headline VARCHAR(150) DEFAULT '' NOT NULL,
    tx_socialmediafields_opengraph_description TINYTEXT,
    tx_socialmediafields_opengraph_images INT(11) UNSIGNED DEFAULT '0' NOT NULL,

    tx_socialmediafields_twitter_headline VARCHAR(150) DEFAULT '' NOT NULL,
    tx_socialmediafields_twitter_description TINYTEXT,
    tx_socialmediafields_twitter_images INT(11) UNSIGNED DEFAULT '0' NOT NULL
);

CREATE TABLE tx_news_domain_model_news (
    tx_socialmediafields_opengraph_headline VARCHAR(150) DEFAULT '' NOT NULL,
    tx_socialmediafields_opengraph_description TINYTEXT,
    tx_socialmediafields_opengraph_images INT(11) UNSIGNED DEFAULT '0' NOT NULL,

    tx_socialmediafields_twitter_headline VARCHAR(150) DEFAULT '' NOT NULL,
    tx_socialmediafields_twitter_description TINYTEXT,
    tx_socialmediafields_twitter_images INT(11) UNSIGNED DEFAULT '0' NOT NULL
);