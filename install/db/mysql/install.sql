create table if not exists b_ichannels_rss 
(
	ID int(11) not null auto_increment,
	NAME varchar(255) not null,
	URL varchar(255) not null,
	IBLOCK_TYPE_ID varchar(50) not null REFERENCES b_iblock_type(ID),
	IBLOCK_ID int(11) not null REFERENCES b_iblock(ID),
	IBLOCK_SECTION_ID int(11) REFERENCES b_iblock_section(ID),
	FREQUENCY int(7) not null,
	MAPPER varchar(255) not null,
	primary key (ID)
) CHARACTER SET cp1251 COLLATE cp1251_general_ci;