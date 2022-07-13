# What does the project do?

The project automates the generation of a set of test files for the project and the validation of changes in them.

# How is it used?

To use the project, it is necessary to follow the following steps:

1. Download the project zip file and unzip it in a folder.
2. Open a command prompt in the project folder.
3. Run the command: php automate-composer-gen.php -r /path/to/repositories -d /path/to/directories-file-path . In this command, it is necessary to replace /path/to/repositories with the path of the folder where you want the generated tests to be saved and /path/to/directories-file-path with the path of the file where the list of the generated tests will be saved.
4. Run the command: php automate-check.php -r /path/to/repositorie-path -c commit -b branch -d /path/to/directories-file-path . In this command, it is necessary to replace /path/to/repositorie-path with the path of the folder where the repository to be validated is located, commit with the id of the commit to be validated, branch with the branch of the repository in which the commit was found and /path/to/directories-file-path with the path of the file where the list of the generated tests is stored.
5. In the command prompt a list of the changes found in the commit will be shown.

# How does it work?

The project consists of two PHP files, one called automate-composer-gen.php and the other called automate-check.php.

The automate-composer-gen.php file is responsible for generating a set of test files for the project.

The automate-check.php file is responsible for validating changes in the commint from the files generated by automate-composer-gen.php.

# Commands

The project has two commands, called automate-composer-gen and automate-check.

The automate-composer-gen command allows you to generate a set of test files for the project. This command receives two arguments, repositories-path and directories-file-path. The repositories-path argument indicates the path of the folder where the generated tests must be saved and directories-file-path indicates the path of the file where the paths of the generated tests must be saved.

The automate-check command allows you to validate changes in the commint from the files generated by automate-composer-gen. This command receives four arguments, repositorie-path, commit, branch and directories-file-path. The repositorie-path argument indicates the path of the folder where the repository to be validated is located, commit indicates the id of the commit to be validated, branch indicates the branch of the repository in which the commit was found and directories-file-path indicates the path of the file where the list of the generated tests is stored.


# Testing
structure of repositories and dependencies created for tests with automate-composer-gen.
-repo1

-----repo2

---------repo1002

---------repo1003
-----repo1001
-repo2
-----repo1002
-----repo1003
-repo3
-----repo1
---------repo2
-------------repo1002
-------------repo1003
---------repo1001
-----repo4
---------repo1003
-----repo1004
-repo4
-----repo1003
-repo5
-----repo1003
-repo6
-----repo5
---------repo1003
Start tests with command: php vendor/bin/codecept run

repo1 - Pipeline CI/CD = 2

repo2 - Pipeline CI/CD = 3

repo3 - Pipeline CI/CD = 1

repo4 - Pipeline CI/CD = 2

repo5 - Pipeline CI/CD = 2
repo6 - Pipeline CI/CD = 1


# DATA BASE
CREATE TABLE Dependency (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    version VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE Repository (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    version VARCHAR(255),
);

CREATE TABLE RepositoryDependency (
    id INT NOT NULL AUTO_INCREMENT,
    repository INT,
    dependency INT,
    FOREIGN KEY (repository) REFERENCES Repository(id),
    FOREIGN KEY (dependency) REFERENCES Dependency(id)
);

ALTER TABLE Dependency
ADD CONSTRAINT name_unique UNIQUE (name);

ALTER TABLE Repository
ADD CONSTRAINT name_unique UNIQUE (name);


# Project files

The project consists of the following files:

1. Automate.php
2. automate-composer-gen.php
3. automate-check.php
4. Composerfiles.php
5. DependenciesTree.php
6. Dependency.php
7. Repository.php
8. helpers.php
9. README.md
