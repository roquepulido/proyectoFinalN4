CREATE TABLE `users` (
	`id_user` int NOT NULL AUTO_INCREMENT,
	`email` varchar(50) NOT NULL UNIQUE,
	`pass` varchar(100) NOT NULL,
	`pass_org` varchar(100),
	`id_rol_fk` int NOT NULL,
	PRIMARY KEY (`id_user`)
);

CREATE TABLE `roles` (
	`id_roles` int NOT NULL AUTO_INCREMENT,
	`name_rol` varchar(30) NOT NULL UNIQUE,
	PRIMARY KEY (`id_roles`)
);

CREATE TABLE `class` (
	`id_class` int NOT NULL AUTO_INCREMENT,
	`name_class` varchar(50) NOT NULL,
	PRIMARY KEY (`id_class`)
);

CREATE TABLE `notes` (
	`id_note` int NOT NULL AUTO_INCREMENT,
	`id_student_fk` int NOT NULL,
	`id_teacher_fk` int NOT NULL,
	`id_class_fk` int NOT NULL,
	`text` varchar(255) NOT NULL,
	PRIMARY KEY (`id_note`)
);

CREATE TABLE `students` (
	`id_student` int NOT NULL,
	`id_user_fk` int NOT NULL,
	`first_name` varchar(50) NOT NULL,
	`last_name` varchar(50) NOT NULL,
	`DNI` varchar(50) NOT NULL,
	`address` varchar(100) NOT NULL,
	`birth_date` varchar(50) NOT NULL,
	PRIMARY KEY (`id_student`)
);

CREATE TABLE `teachers` (
	`id_teacher` int NOT NULL,
	`id_user_fk` int NOT NULL,
	`id_class_fk` int NOT NULL,
	`first_name` varchar(50) NOT NULL,
	`last_name` varchar(50) NOT NULL,
	`address` varchar(100) NOT NULL,
	`birth_date` varchar(50) NOT NULL,
	PRIMARY KEY (`id_teacher`)
);

CREATE TABLE `grades` (
	`id_grade` int NOT NULL AUTO_INCREMENT,
	`id_class_fk` int NOT NULL,
	`id_student_fk` int NOT NULL,
	`value` int NOT NULL,
	PRIMARY KEY (`id_grade`)
);

ALTER TABLE `users` ADD CONSTRAINT `users_fk0` FOREIGN KEY (`id_rol_fk`) REFERENCES `roles`(`id_roles`);

ALTER TABLE `notes` ADD CONSTRAINT `notes_fk0` FOREIGN KEY (`id_student_fk`) REFERENCES `students`(`id_student`);

ALTER TABLE `notes` ADD CONSTRAINT `notes_fk1` FOREIGN KEY (`id_teacher_fk`) REFERENCES `teachers`(`id_teacher`);

ALTER TABLE `notes` ADD CONSTRAINT `notes_fk2` FOREIGN KEY (`id_class_fk`) REFERENCES `class`(`id_class`);

ALTER TABLE `students` ADD CONSTRAINT `students_fk0` FOREIGN KEY (`id_user_fk`) REFERENCES `users`(`id_user`);

ALTER TABLE `teachers` ADD CONSTRAINT `teachers_fk0` FOREIGN KEY (`id_user_fk`) REFERENCES `users`(`id_user`);

ALTER TABLE `teachers` ADD CONSTRAINT `teachers_fk1` FOREIGN KEY (`id_class_fk`) REFERENCES `class`(`id_class`);

ALTER TABLE `grades` ADD CONSTRAINT `grades_fk0` FOREIGN KEY (`id_class_fk`) REFERENCES `class`(`id_class`);

ALTER TABLE `grades` ADD CONSTRAINT `grades_fk1` FOREIGN KEY (`id_student_fk`) REFERENCES `students`(`id_student`);
