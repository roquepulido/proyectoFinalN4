CREATE TABLE `users` (
	`id_user` int NOT NULL AUTO_INCREMENT,
	`email` varchar(50) NOT NULL UNIQUE,
	`pass` varchar(100) NOT NULL,
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
	`id_grade_fk` int DEFAULT 'null',
	`id_class_fk` int NOT NULL,
	`id_student_fk` int NOT NULL
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

INSERT INTO roles(name_rol) VALUES ('admin');
INSERT INTO roles(name_rol) VALUES ('maestro');
INSERT INTO roles(name_rol) VALUES ('estudiante');

INSERT INTO users(email,pass_org,id_rol_fk,pass) VALUES ('admin@admin',' ','admin',1,"$2y$10$n8SR7VXuwtWgQIJYE8lt8uIS5WnEQNJa.0YjONqU/EQMq3JcvePF2");
INSERT INTO users(email,pass_org,id_rol_fk,pass) VALUES ('maestro@maestro',' ','maestro',2,"$2y$10$FAGuvW.EjQSC5HPxxLQaRePA2w9VyfRhnVP1xDKnyCI6ZkjXGUpFS");
INSERT INTO users(email,pass_org,id_rol_fk,pass) VALUES ('alumno@alumno',' ','alumno',3,"$2y$10$CnIFwjrBp.D7kWH7KPRhke5p7EwMAMfTXYht0S.Vyizzc9iRCp3oa");

insert into classes values('1',null,'Materia 1');
insert into classes values('2',null,'Materia 2');
insert into classes values('3',null,'Materia 3');
insert into classes values('4',null,'Materia 4');
insert into classes values('5',null,'Materia 5');

