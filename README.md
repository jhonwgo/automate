# What does the project do?

Automate is a console command that is used to determine which repositories have been affected by a commit or change in any of the repositories it includes. Automate is focused on a CI/CD system that, basically, needs to understand dependencies declared using composer between code located in different repositories. When there is a commit in any repository, Automate is called with a path to a git, a commit Id, and the branch where the commit has been made, as parameters. Automate then analyses the dependencies and determines which repositories have been affected by the commit.

# How is it used?

To use the project, it is necessary to follow the following steps:

1) Download the project from the following github repository:

2) Install dependencies using composer:

composer install

3) Generate the test repositories. For this, the following command is executed:

php automate-composer-gen.php -r /tmp/repositories -d /tmp/directories.txt

4) To validate if the generated repositories were correctly analyzed, the following command is executed:

php automate-check.php -r /tmp/repositories/library4 -c fdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfd -b master -d /tmp/directories.txt

You should see the following output:

array (
  0 => 'library1',
  1 => 'library2',
)

5) To validate that the composer names are being correctly resolved, the following command is executed:

php automate-check-name.php -n library2 -d /tmp/directories.txt

You should see the following output:

array (
  0 => 'library1',
  1 => 'project2',
)

6) The project also has a script to delete the generated repositories. For this, the following command is executed:

php automate-composer-del.php -r /tmp/repositories -d /tmp/directories.txt

7) Finally, to generate the database structures, the file called database.sql is executed.


# Commands

The project has  the following commands:

* php automate-composer-gen.php -r /tmp/repositories -d /tmp/directories.txt

This command is responsible for generating the test repositories.

* php automate-check.php -r /tmp/repositories/library4 -c fdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfd -b master -d /tmp/directories.txt

This command is responsible for validating changes in the commint from the files generated by automate-composer-gen.php.

* php automate-check-name.php -n library2 -d /tmp/directories.txt

This command is responsible for using composer name to validate for validating changes in the commint from the files generated by automate-composer-gen.php.

* php  automate-composer-del.php -r /tmp/repositories -d /tmp/directories.txt

This command is responsible for deleting the test files generated by the project.

# Tests

The project includes several tests that are used to validate the functionality of the developed methods. These tests are located in the tests folder. To execute the tests, the following command is executed:

php vendor/bin/codecept run

This is the structure of test repositories generated.

-repo1

-----ver:1.0

---------repo2:1.0

---------repo1001:1.0

-----ver:2.0

---------repo2:2.0

---------repo1001:1.0


-repo2

-----ver:1.0

---------repo1002:1.0

---------repo1003:1.0

-----ver:2.0

---------repo1002:1.0

---------repo1003:1.0

---------repo6:1.0


-repo3

-----ver:1.0

---------repo1:1.0

---------repo4:1.0

---------repo1004:1.0


-repo4

-----ver:1.0

---------repo1003:1.0


-repo5

-----ver:1.0

---------repo1003:1.0


-repo6

-----ver:1.0

---------repo5:1.0

-----ver:2.0

---------repo5:1.0

---------repo3:1.0


These are the dependencies affected by a change in a repository.

-repo1:1.0

-----repo3:1.0

-----repo6:2.0


-repo1:2.0

-----0


-repo2:1.0

-----repo1:1.0

---------repo3:1.0

-------------repo6:2.0


-repo2:2.0

-----repo1:2.0


-repo3:1.0

-----repo6:2.0


-repo4:1.0

-----repo3:1.0

---------repo6:2.0


-repo5:1.0

-----repo6:2.0

-----repo6:1.0

---------repo2:2.0

-------------repo1:2.0


-repo6:1.0

-----repo2:2.0

---------repo1:2.0


-repo6:2.0

-----0


# DATA BASE
```
CREATE TABLE `repos` (
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  PRIMARY KEY (`name`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
```
CREATE TABLE `deps` (
  `repo_name` varchar(50) NOT NULL,
  `repo_version` varchar(50) NOT NULL,
  `dep_name` varchar(50) NOT NULL,
  `dep_version` varchar(50) NOT NULL,
  PRIMARY KEY (`repo_name`,`repo_version`,`dep_name`,`dep_version`),
  KEY `fk_deps_repos1_idx` (`repo_name`,`repo_version`),
  CONSTRAINT `fk_deps_repos1` FOREIGN KEY (`repo_name`, `repo_version`) REFERENCES `repos` (`name`, `version`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

# Project files

The project consists of the following files:

1. Automate.php
2. automate-composer-gen.php
3. automate-composer-del.php
4. automate-check.php
5. automate-check-name.php
6. Composerfiles.php
7. DependenciesTree.php
8. Dependency.php
9. Repository.php
10. helpers.php
11. README.md
