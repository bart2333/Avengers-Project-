DROP DATABASE IF EXISTS project_tracking;
CREATE DATABASE project_tracking; 

CREATE TABLE team_members (
    mem_id      INT            NOT NULL    AUTO_INCREMENT,
    mem_fname   VARCHAR(60)    NOT NULL,
    mem_lname   VARCHAR(60)    NOT NULL,
    username    VARCHAR(255),
    password    VARCHAR(255),
	reset_pass	VARCHAR(255),
	skills      VARCHAR(255),
    PRIMARY KEY (mem_id),
    UNIQUE INDEX username (username)
);


CREATE TABLE project_director (
    dir_id      INT           NOT NULL    AUTO_INCREMENT,
    dir_fname   VARCHAR(60)   NOT NULL,
    dir_lname   VARCHAR(60)   NOT NULL,
    username    VARCHAR(255)   NOT NULL,
    password    VARCHAR(255)   NOT NULL,
	reset_pass	VARCHAR(255),
    is_dir      VARCHAR(4),
    PRIMARY KEY (dir_id),
    UNIQUE INDEX username (username)
);

ALTER TABLE project_director AUTO_INCREMENT=200;


CREATE TABLE accounting (
    account_id         INT           NOT NULL,
    acc_name           VARCHAR(30)   NOT NULL,
    acc_create_date    DATE          NOT NULL,
    PRIMARY KEY (account_id)
);

CREATE TABLE project (
    project_id      	   INT           NOT NULL     AUTO_INCREMENT,
    project_name    	   VARCHAR(40)   NOT NULL,
    dir_id          	   INT,
    account_id      	   INT,
    pro_start_date  	   DATE,
    pro_end_date    	   DATE,
    project_description    VARCHAR(255),
	tafp1				   DECIMAL(10,2),	
	code                   DECIMAL(10,2),
	personMonths           DECIMAL(10,2),
	months                 DECIMAL(10,2),
	persons                DECIMAL(10,2),
	personnel_cost  	   DECIMAL(10,2),
    PRIMARY KEY (project_id),
    FOREIGN KEY (account_id) REFERENCES accounting (account_id) ON DELETE CASCADE
);

ALTER TABLE project AUTO_INCREMENT=300;


CREATE TABLE team (
    team_id      INT           NOT NULL AUTO_INCREMENT,
    project_id   INT           NOT NULL,
    team_name    VARCHAR(20)   NOT NULL,
    team_description     VARCHAR(255),
    PRIMARY KEY (team_id),
    FOREIGN KEY (project_id) REFERENCES project (project_id) ON DELETE CASCADE
);

ALTER TABLE team AUTO_INCREMENT = 900;

CREATE TABLE teams_list (
    teams_list_id     INT     NOT NULL AUTO_INCREMENT,
    mem_id      INT            NOT NULL,
    team_id     INT            NOT NULL,
    is_lead     VARCHAR(4)        NOT NULL,
    PRIMARY KEY (teams_list_id),
    FOREIGN KEY (mem_id) REFERENCES team_members (mem_id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES team (team_id) ON DELETE CASCADE
);

ALTER TABLE teams_list AUTO_INCREMENT = 1111;

CREATE TABLE tasks (
    task_id         INT           NOT NULL AUTO_INCREMENT,
    task_name       VARCHAR(30)   NOT NULL,
    task_category   VARCHAR(30),
    PRIMARY KEY (task_id)
);

ALTER TABLE tasks AUTO_INCREMENT=500;

CREATE TABLE task_list (
    task_list_id   INT         NOT NULL  AUTO_INCREMENT,
    task_name      VARCHAR(30) NOT NULL,
    project_id     INT         NOT NULL,
    task_id        INT         NOT NULL,
    due_date       DATE,
    mem_id         INT,
    team_id        INT,
    PRIMARY KEY (task_list_id, task_id),
    FOREIGN KEY (task_id) REFERENCES tasks (task_id),
    FOREIGN KEY (project_id) REFERENCES project (project_id)  ON DELETE CASCADE
);

ALTER TABLE task_list AUTO_INCREMENT=700;

CREATE TABLE archive_project (
    project_id      	   INT           NOT NULL     AUTO_INCREMENT,
    project_name    	   VARCHAR(40)   NOT NULL,
    dir_id          	   INT,
    account_id      	   INT,
    pro_start_date  	   DATE,
    pro_end_date    	   DATE,
    project_description    VARCHAR(255),
	tafp1				   DECIMAL(10,2),	
	code                   DECIMAL(10,2),
	personMonths           DECIMAL(10,2),
	months                 DECIMAL(10,2),
	persons                DECIMAL(10,2),
	personnel_cost  	   DECIMAL(10,2),
    PRIMARY KEY (project_id)
);

ALTER TABLE archive_project AUTO_INCREMENT=10000;

INSERT INTO accounting (account_id, acc_name, acc_create_date)
    VALUES (123456789, 'CIS Budget', '2022-02-09'),
           (555555555, 'CS Budget', '2022-02-01'),
           (333333333, 'Reserve', '2021-12-10');

		   
INSERT INTO `project_director` (`dir_id`, `dir_fname`, `dir_lname`, `username`, `password`, `is_dir`) VALUES
(200, 'admin', 'admin', 'admin@admin', '$2y$10$4iN3o5tGfw3jU69QLw6kEuTAE3Zh8ueroIQ2Iw7oQPo6z9Q8co6Ei', NULL), /*password is admin*/
(201, 'Pratibha', 'Menon', 'menon@calu.edu', '$2y$10$Dja4o/.M7gaoCS8anz4OGu33H397ViacoH/qJtzlSjt1kGWCVVeBu', NULL), /*password is Admin1*/
(202, 'Gina', 'Boff', 'boff@calu.edu', '$2y$10$2gL5I20lUdP0rJDnqIfxk.bd6GsOW6KVynKGGLjhJBHSw9dNw3Fcm', NULL); /*password is Admin1*/

INSERT INTO tasks (task_name, task_category)
    VALUES ('Create ERD', 'Planning'),
           ('Create DFD', 'Planning'),
           ('Create WBS', 'Planning'),
		   ('Project Charter', 'Planning'),
		   ('Team Contract', 'Planning'),
		   ('Database Development', 'Development'),
		   ('Cost Calc Page', 'Development'),
           ('Program Login', 'Development');

INSERT INTO `project` (`project_id`, `project_name`, `dir_id`, `account_id`, `pro_start_date`, `pro_end_date`, `project_description`, `tafp1`, `code`, `personMonths`, `months`, `persons`, `personnel_cost`) VALUES
(300, 'Project Scheduling and Tracking', 201, NULL, '2021-08-23', '2022-04-25', 'Build system to create and track projects in the CIS department.', NULL, NULL, NULL, NULL, NULL, NULL),
(301, 'ABC Corp Project', 200, 123456789, '2022-03-04', '2022-04-29', 'Test Test ', '76.50', '4972.50', '6.96', '2.75', '2.53', '632.50'),
(302, 'XYZ Corp Project', 200, 123456789, '2022-03-18', '2022-04-30', 'Test Test Test ', '246.96', '16052.40', '22.47', '4.07', '5.52', '1380.00');

INSERT INTO task_list (task_name, project_id, task_id, due_date, mem_id)
    VALUES ('Create ERD', 300, 500, NULL, 1),
           ('Create DFD', 300, 501, NULL, NULL),
           ('Create WBS', 300, 502, NULL, NULL);

INSERT INTO `team` (`team_id`, `project_id`, `team_name`) VALUES
(900, 300, 'Avengers'),
(901, 301, 'Team XYZ'),
(902, 302, 'Team Smith');
	
INSERT INTO `team_members` (`mem_id`, `mem_fname`, `mem_lname`, `username`, `password`, `skills`) VALUES
(1, 'Stu', 'Dent', 'student@student', '$2y$10$umn.f16GmwTbZk5nU6bALOHJn7Z8As0hvVDar.5tAFM8jSVhluUvC', 'Administration'),
(2, 'John ', 'Doe', 'jdoe@calu.edu', '$2y$10$3q/0Dk9/13bhh8ffeL0tVuHktzt4evhpuZ7kfrcRvEkGrYHVMEL3q', 'Database Management\r\nPHP Experience\r\nJavascript Experience\r\nJava Experience'),
(3, 'Sarah ', 'Shaffer', 'sshaffer@aaa.com', '$2y$10$E20pkdav3ELbeC/HJ4xPfOc5NX.StVYw2vo267SQGSnYL/qk1VLj6', 'Javascript Experience \r\nPublic Speaking Experience');

INSERT INTO `teams_list` (`mem_id`, `team_id`, `is_lead`) VALUES
(2, 901, 'Y'),
(1, 902, 'N'),
(3, 900, 'N');
