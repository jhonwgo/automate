<?php
require_once('Automate.php');

$help="
automate-composer-gen

This allows you to generate test data to validate the functions developed for Automate. It generates 6 folders with their respective composer files and also starts git and creates commits and tags.

Usage:

-r --repositories-path      a folder path where the generated test repositories will be saved
-d --directories-file-path  saves the paths of the generated repositories in a file, this file is required to run automate-check

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

";

$argumentos = getopt("r:d:", array(
    "repositories-path:",
    "directories-file-path:"
));

//If the options are not set, we exit and indicate the usage mode.
if (
    !(isset($argumentos["r"]) || isset($argumentos["repositories-path"]))
    ||
    !(isset($argumentos["d"]) || isset($argumentos["directories-file-path"]))
) {
    exit($help);
}

//All options are well established until here
$repositoriesPath = isset($argumentos["r"]) ? $argumentos["r"] : $argumentos["repositories-path"];
if (substr($repositoriesPath, -1)!="/"){
	$repositoriesPath  = $repositoriesPath . "/";
}

$directoriesFilePath = isset($argumentos["d"]) ? $argumentos["d"] : $argumentos["directories-file-path"];
echo "automate-composer-gen" . PHP_EOL;
echo "Generates repository files for testing." . PHP_EOL;
echo "repositories-path: $repositoriesPath" . PHP_EOL;
echo "directories-file-path: $directoriesFilePath" . PHP_EOL;

composer_gen($repositoriesPath, $directoriesFilePath);
echo "files created successfully." . PHP_EOL;
