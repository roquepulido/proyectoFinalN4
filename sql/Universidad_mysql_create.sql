CREATE TABLE `users` (
	`id_user` int NOT NULL AUTO_INCREMENT,
	`email` varchar(50) NOT NULL UNIQUE,
	`pass` varchar(100) NOT NULL DEFAULT " ",
	`id_rol_fk` int NOT NULL,
	`active` BOOLEAN NOT NULL DEFAULT true,
	`pass_org` varchar(100),
	PRIMARY KEY (`id_user`)
);

CREATE TABLE `roles` (
	`id_rol` int NOT NULL AUTO_INCREMENT,
	`name_rol` varchar(30) NOT NULL UNIQUE,
	PRIMARY KEY (`id_rol`)
);

CREATE TABLE `classes` (
	`id_class` int NOT NULL AUTO_INCREMENT,
	`id_teacher_fk` int,
	`name_class` varchar(50) NOT NULL,
	PRIMARY KEY (`id_class`)
);

CREATE TABLE `notes` (
	`id_note` int NOT NULL AUTO_INCREMENT,
	`id_student_fk` int NOT NULL,
	`id_class_fk` int NOT NULL,
	`text` varchar(255) NOT NULL,
	`read_it` tinyint NOT NULL DEFAULT '0',
	PRIMARY KEY (`id_note`)
);

CREATE TABLE `students` (
	`id_student` int NOT NULL AUTO_INCREMENT,
	`id_user_fk` int NOT NULL,
	`first_name` varchar(50) NOT NULL,
	`last_name` varchar(50) NOT NULL,
	`address` varchar(100) NOT NULL,
	`birth_date` varchar(50) NOT NULL,
	`DNI` varchar(50) NOT NULL,
	PRIMARY KEY (`id_student`)
);

CREATE TABLE `teachers` (
	`id_teacher` int NOT NULL AUTO_INCREMENT,
	`id_user_fk` int NOT NULL,
	`first_name` varchar(50) NOT NULL,
	`last_name` varchar(50) NOT NULL,
	`address` varchar(100) NOT NULL,
	`birth_date` varchar(50) NOT NULL,
	PRIMARY KEY (`id_teacher`)
);

CREATE TABLE `student_class` (
	`id_student_class` int NOT NULL AUTO_INCREMENT,
	`id_grade_fk` int DEFAULT NULL,
	`id_class_fk` int NOT NULL,
	`id_student_fk` int NOT NULL,
	PRIMARY KEY (`id_student_class`)
);

CREATE TABLE `grades` (
	`id_grade` int NOT NULL AUTO_INCREMENT,
	`value` int NOT NULL,
	PRIMARY KEY (`id_grade`)
);

ALTER TABLE `users` ADD CONSTRAINT `users_fk0` FOREIGN KEY (`id_rol_fk`) REFERENCES `roles`(`id_rol`);

ALTER TABLE `classes` ADD CONSTRAINT `classes_fk0` FOREIGN KEY (`id_teacher_fk`) REFERENCES `teachers`(`id_teacher`);

ALTER TABLE `notes` ADD CONSTRAINT `notes_fk0` FOREIGN KEY (`id_student_fk`) REFERENCES `students`(`id_student`);

ALTER TABLE `notes` ADD CONSTRAINT `notes_fk1` FOREIGN KEY (`id_class_fk`) REFERENCES `classes`(`id_class`);

ALTER TABLE `students` ADD CONSTRAINT `students_fk0` FOREIGN KEY (`id_user_fk`) REFERENCES `users`(`id_user`);

ALTER TABLE `teachers` ADD CONSTRAINT `teachers_fk0` FOREIGN KEY (`id_user_fk`) REFERENCES `users`(`id_user`);

ALTER TABLE `student_class` ADD CONSTRAINT `student_class_fk0` FOREIGN KEY (`id_grade_fk`) REFERENCES `grades`(`id_grade`);

ALTER TABLE `student_class` ADD CONSTRAINT `student_class_fk1` FOREIGN KEY (`id_class_fk`) REFERENCES `classes`(`id_class`);

ALTER TABLE `student_class` ADD CONSTRAINT `student_class_fk2` FOREIGN KEY (`id_student_fk`) REFERENCES `students`(`id_student`);
-- INSERT roles
INSERT INTO roles(name_rol) VALUES ('admin');
INSERT INTO roles(name_rol) VALUES ('maestro');
INSERT INTO roles(name_rol) VALUES ('estudiante');
-- Insert USERS

INSERT INTO users (id_user, email, pass_org, id_rol_fk, pass) VALUES (1, 'admin@admin','admin',1 ,"$2y$10$cCLsgeiCehzoAE0M3kV9SOD5SP5gv8NRm0qy188qS3KZcYetw2b0u");
INSERT INTO users (id_user, email, pass_org, id_rol_fk, pass) VALUES (2, 'maestro@maestro','maestro',2,"$2y$10$8MUIaai//tc84oAuZBJyyuRm0r8woa6wQBqHY2XOQitJVRyl3eLAe");
INSERT INTO users (id_user, email, pass_org, id_rol_fk, pass) VALUES (3, 'alumno@alumno','alumno',3,"$2y$10$Cdc2kZI29h1GSOFtL26xK.S/bCVYomKDkVPv.pJynGEiQT1Ff38.u");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (4, 'hedelheid0@hostgator.com', 'iHTwP9mdOkd5', 2,"$2y$10$IQrzBO3v25qwjAobeYvxheSwYvdaGU2dqPQKnhRLP6wHaXh3mK/uO");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (5, 'godornan1@state.tx.us', 'LSoS7dh0W', 2,"$2y$10$X5Si8/4Pcv5zk/dzKyB6Z.5O30ZUrK9MbIwVr5dLAyAlf3gH4hpX2");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (6, 'reverton2@odnoklassniki.ru', 'OasrcgFLlrzc', 2,"$2y$10$rJbyxqMlhz9K97IGxt3H.ON1.MvGdLnlBHrlt0nKcKfHRbuyDpvYq");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (7, 'gmaplesden3@woothemes.com', 'zXbVgEUyoJ6d', 2,"$2y$10$zeUPBY9RnyJw5aUFcr/vo.XYBZkvroW4BuyTkjVUfuLcfKY3m1wTS");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (8, 'tgogan4@psu.edu', 'yR7hdHOX', 2,"$2y$10$kkh57VOpu86B8.XYFB8PkuPcZR39YUAIugr7qXvdKnzl9yG8tdBa.");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (9, 'ztoulamain5@tripod.com', 'FLGfikZVB', 2,"$2y$10$Hnj1H1XK.xkHSHirrDWUOOV/LOkWwxr77GzPp6cArsz1c.UPB8.YW");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (10, 'mheigho6@noaa.gov', 'DK9MLP', 2,"$2y$10$WqxmDaEmXjWuYY2SYNmJ4.F7Z9Zh3IssURPyQRWMq2p1ndhloCvs.");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (11, 'mmcconnulty7@tinypic.com', 'DgedsbR', 3,"$2y$10$UZhr7YirR8GVRgT7uED4iOHF.95szRQ7z4qcunqGxEJ2K2Ds1Jb46");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (12, 'ehampshire8@jiathis.com', 'zfeVNYziVN', 3,"$2y$10$NVyNc1NLJGtkZiAtnGQtdeWhqpzkl98mnQJbTzZ81vBTh/kMrda.i");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (13, 'melsmor9@angelfire.com', 'DNKSWiMx7FD', 3,"$2y$10$xYI1HwwEACB1hjKwbONMReEcPYlB5HVkFLDHljMwKgozqh7iUhiBK");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (14, 'fheimsa@gizmodo.com', 'airllwmoAa', 3,"$2y$10$3WkmuXhiYyis6qZN836rIeWPOY0h7psZ3tqAMBk2MBczB26dCKbIO");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (15, 'gpeaseeb@imgur.com', '0z3oUOwySpmj', 3,"$2y$10$kLLVHyvUYqsYpaDzp1mEfurs4JHglvjZd435DRZY0TEJhGgXtxB3K");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (16, 'djanicijevicc@tamu.edu', '5dujd1zcT52', 3,"$2y$10$1pK95pfHp2bg4eZVlv1tuu2SNh/PSG0Qd6mSeaZdn7yFLU52spjxC");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (17, 'zpiolad@t.co', 'QLKczq6qz', 3,"$2y$10$mrPeZ3FRri4xyzkfd5FtauGSoHgZyRnvXR5HnagDPcH1HM96/z05O");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (18, 'tvedekhine@t.co', 'l1IiXrSn', 3,"$2y$10$UdrMmT9ALgzPIXhpY4cxPOtcpZOzATs0MmkXC83jiAJiXOOGD5YH2");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (19, 'cdefondf@cnn.com', 'h5xm3B0QL93D', 3,"$2y$10$/QN2C0dCQnh5RbsMj2YTzuyHSOZ62.UP/UOfEs9JJXJ5oJECSN6Zm");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (20, 'glithgowg@netvibes.com', '77ashqHDc', 3,"$2y$10$EapjBTyD9ZCArP6E/XXAVOU3HOgUH6hJfZkAOpGbaRMrkICMkYpoa");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (21, 'aluckhamh@geocities.jp', 'sB9bHkl', 3,"$2y$10$yGUgC9kIBjMzyMxlwzgguu086beBUcMwP8kHyTElcsZkRWIY3UTFC");
insert into users (id_user, email, pass_org, id_rol_fk, pass) values (22, 'cmossdalei@about.com', 'RfDULBfF', 3,"$2y$10$Y1CaESFNttTx4JVINTpECulBD.ddYi5c4x4N73.6lHCoJg6UCmFMu");


-- INSERT CLASS VALUES 

insert into classes values('1',null,'Astronomía');
insert into classes values('2',null,'Biología');
insert into classes values('3',null,'Biomedicina');
insert into classes values('4',null,'Ciencia de materiales');
insert into classes values('5',null,'Ciencias Ambientales');
insert into classes values('6',null,'Ciencias básicas');
insert into classes values('7',null,'Ciencias de la Tierra');

-- Teachers

insert into teachers (id_teacher, id_user_fk, first_name, last_name, address, birth_date) values (1, 4, 'Kerwin', 'Cuerdall', '70115 Maywood Center', '2/12/1987');
insert into teachers (id_teacher, id_user_fk, first_name, last_name, address, birth_date) values (2, 5, 'Xerxes', 'Trafford', '55259 Sycamore Place', '2/3/1995');
insert into teachers (id_teacher, id_user_fk, first_name, last_name, address, birth_date) values (3, 6, 'Sly', 'Enderle', '5 Longview Place', '9/20/1988');
insert into teachers (id_teacher, id_user_fk, first_name, last_name, address, birth_date) values (4, 7, 'Cy', 'Champness', '98248 Esch Court', '2/7/1987');
insert into teachers (id_teacher, id_user_fk, first_name, last_name, address, birth_date) values (5, 8, 'Conroy', 'Ricoald', '5516 Bartelt Trail', '2/18/1991');
insert into teachers (id_teacher, id_user_fk, first_name, last_name, address, birth_date) values (6, 9, 'Nowell', 'Blasoni', '60 Raven Center', '3/28/1992');
insert into teachers (id_teacher, id_user_fk, first_name, last_name, address, birth_date) values (7, 10, 'Loria', 'McAw', '535 Glacier Hill Way', '3/1/1993');
insert into teachers (id_teacher, id_user_fk, first_name, last_name, address, birth_date) values (8, 2, 'Loria', 'McAw DEMO', '535 Glacier Hill Way', '3/1/1993');

-- estudiantes

insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (1, 11, 'Bryon', 'McGookin', '55 Hovde Drive', '12/2/2003', '7422671157');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (2, 12, 'Eddi', 'Jursch', '50896 Morning Pass', '10/27/2018', '6598222028');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (3, 13, 'Aurthur', 'Deeth', '2288 Granby Street', '9/23/2009', '5945491241');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (4, 14, 'Rex', 'Dragge', '99 Kensington Parkway', '5/27/2014', '1871813719');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (5, 15, 'Colin', 'Floodgate', '901 Autumn Leaf Circle', '2/26/2015', '7621099038');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (6, 16, 'Emily', 'Chapellow', '481 Bellgrove Lane', '12/4/2005', '1331236509');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (7, 17, 'Blinni', 'MacCole', '103 Bartelt Drive', '4/12/2018', '6940893490');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (8, 18, 'Tanney', 'Kenan', '01 Esch Way', '12/17/2003', '2328831540');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (9, 19, 'Madlin', 'Crips', '38 Delladonna Crossing', '3/13/2005', '6389277431');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (10, 20, 'Steward', 'Onraet', '662 Butterfield Point', '10/15/2013', '6495930216');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (11, 21, 'Cassy', 'Usmar', '27483 Orin Center', '12/13/2016', '1683850521');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (12, 22, 'Saunderson', 'Brecon', '66 Hintze Parkway', '3/4/2017', '5768874968');
insert into students (id_student, id_user_fk, first_name, last_name, address, birth_date, DNI) values (13, 3, 'Saunderson', 'Brecon DEMO', '66 Hintze Parkway', '3/4/2017', '5768874968');