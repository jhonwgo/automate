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

# Project files

The project consists of the following files:

1. automate-composer-gen.php
2. automate-check.php
3. Composerfiles.php
4. DependenciesTree.php
5. Dependency.php
6. Repository.php
7. README.md
