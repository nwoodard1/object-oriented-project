create table author (
	authorId BINARY(16) NOT NULL,
	authorAvatarUrl VARCHAR(255),
	authorActivationToken CHAR(32)
	authorEmail VARCHAR(128) NOT NULL,
	authorHash CHAR(97) NOT NULL,
	authorUsername VARCHAR(32) NOT NULL,
	unique (authorEmail),
	unique (authorUsername),
	INDEX (authorEmail),
	primary key (authorId)
);

