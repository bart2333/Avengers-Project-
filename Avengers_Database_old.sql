DROP DATABASE IF EXISTS project_tracking;
CREATE DATABASE project_tracking;

CREATE TABLE team_members (
    mem_id      INT            NOT NULL    AUTO_INCREMENT,
    mem_fname   VARCHAR(60)    NOT NULL,
    mem_lname   VARCHAR(60)    NOT NULL,
    username    VARCHAR(255),
    password    VARCHAR(255),
    PRIMARY KEY (mem_id),
    UNIQUE INDEX username (username)
);



CREATE TABLE project_director (
    dir_id      INT           NOT NULL    AUTO_INCREMENT,
    dir_fname   VARCHAR(60)   NOT NULL,
    dir_lname   VARCHAR(60)   NOT NULL,
    username    VARCHAR(255)   NOT NULL,
    password    VARCHAR(255)   NOT NULL,
    PRIMARY KEY (dir_id)
);

ALTER TABLE project_director AUTO_INCREMENT=200;



CREATE TABLE accounting (
    account_id         INT           NOT NULL,
    acc_name           VARCHAR(30)   NOT NULL,
    acc_create_date    DATE          NOT NULL,
    PRIMARY KEY (account_id)
);

CREATE TABLE project (
    project_id      INT           NOT NULL     AUTO_INCREMENT,
    project_name    VARCHAR(30)   NOT NULL,
    dir_id          INT           NOT NULL,
    personnel_cost  VARCHAR(10),
    account_id      INT,
    pro_start_date  DATE,
    pro_end_date    DATE,
    PRIMARY KEY (project_id),
    FOREIGN KEY (dir_id) REFERENCES project_director (dir_id),
    FOREIGN KEY (account_id) REFERENCES accounting (account_id)
);

ALTER TABLE project AUTO_INCREMENT=300;


CREATE TABLE team (
    team_id      INT           NOT NULL,
    project_id   INT           NOT NULL,
    team_name    VARCHAR(20)   NOT NULL,
    PRIMARY KEY (team_id),
    FOREIGN KEY (project_id) REFERENCES project (project_id)
);

CREATE TABLE teams_list (
    mem_id      INT            NOT NULL,
    team_id     INT            NOT NULL,
    is_lead     BIT            NOT NULL,
    PRIMARY KEY (mem_id, team_id),
    FOREIGN KEY (mem_id) REFERENCES team_members (mem_id),
    FOREIGN KEY (team_id) REFERENCES team (team_id)
);

CREATE TABLE tasks (
    task_id         INT           NOT NULL AUTO_INCREMENT,
    task_name       VARCHAR(30)   NOT NULL,
    task_category   VARCHAR(30),
    due_date        DATE,
    mem_id          INT,
    PRIMARY KEY (task_id),
    FOREIGN KEY (mem_id) REFERENCES team_members (mem_id)
);

ALTER TABLE tasks AUTO_INCREMENT=500;

CREATE TABLE task_list (
    task_list_id   INT         NOT NULL   AUTO_INCREMENT,
    task_name      VARCHAR(30) NOT NULL,
    task_id        INT         NOT NULL,
    project_id     INT         NOT NULL,
    PRIMARY KEY (task_list_id),
    FOREIGN KEY (task_id) REFERENCES tasks (task_id),
    FOREIGN KEY (project_id) REFERENCES project (project_id)
);

ALTER TABLE task_list AUTO_INCREMENT=700;

INSERT INTO team_members (mem_fname, mem_lname, username, password)
    VALUES ('John', 'Seghi', 'jayseghi', 'helloworld'),
           ('Rebecca', 'Smitley', 'becca', 'tinyavenger'),
           ('Bartholomew', 'Kulus', 'bart', 'password');

INSERT INTO project_director (dir_fname, dir_lname, username, password)
    VALUES ('Pratibha', 'Menon', 'doctorM', 'SAROCKS'),
           ('Gina', 'Boff', 'docboff', 'iheartdatabases');

INSERT INTO tasks (task_name, task_category, due_date, mem_id)
    VALUES ('Create ERD', 'Planning', NULL, NULL),
           ('Create DFD', 'Planning', NULL, NULL),
           ('Create WBS', 'Planning', NULL, NULL),
           ('Program Login', 'Development', NULL, NULL);


