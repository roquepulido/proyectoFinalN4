CREATE TABLE `users` (
	`id_user` int NOT NULL AUTO_INCREMENT,
	`email` varchar(50) NOT NULL UNIQUE,
	`pass` varchar(100) NOT NULL,
	`pass_org` varchar(100) NOT NULL,
	`id_rol_fk` int NOT NULL,
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
	`id_grade_fk` int,
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

INSERT INTO users(email,pass,pass_org,id_rol_fk) VALUES ('admin@admin.com',' ','admin',1);
INSERT INTO users(email,pass,pass_org,id_rol_fk) VALUES ('maestro@maestro.com',' ','maestro',2);
INSERT INTO users(email,pass,pass_org,id_rol_fk) VALUES ('alumno@alumno.com',' ','alumno',3);
