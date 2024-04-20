create table appuser (
	userid varchar(50) primary key,
	password varchar(50)
);

create table votes (
    userid varchar(50) references appuser(userid),
    vote varchar(3);
);