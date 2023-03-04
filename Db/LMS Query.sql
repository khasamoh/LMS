create table tbl_User(
	UserID int(11) auto_increment primary key,
	FName varchar(50) not null,
	LName varchar(100),
	Gender varchar(100),
	Address varchar(100),
	Phone varchar(50), 
	UserName varchar(50) not null,
	Password varchar(100) not null,
	Privilage varchar(50) not null,
	Status varchar(30) not null);

create table tbl_Subject(
	SubjectID int(11) auto_increment primary key,
	SubjectCode varchar(50) not null,
	SubjectName varchar(50) not null,
	UserID int(11) not null,
	constraint fk1 foreign key(UserID) references tbl_User(UserID) on delete cascade on update cascade);

create table tbl_Material(
	MtrID int(11) auto_increment primary key,
	Title varchar(500) not null,
	FileType varchar(500) not null,
	FlName varchar(500) not null,
	UploadDate date,
	SubjectID int(11) not null,
	constraint fk2 foreign key(SubjectID) references tbl_Subject(SubjectID) on delete cascade on update cascade);

/*First User*/
INSERT INTO tbl_User VALUES('','Khamis','Mohd','Male','Mwera','0773274743','Admin',MD5('123'),'Administrator','Active');