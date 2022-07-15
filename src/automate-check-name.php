<?php

require_once('Automate.php');

$help="
automate-check-name

This function is focused on a CI / CD system, this function allows you to know through a composer name which other composer.json include it both directly and indirectly.

Usage:

-n --name                   composer name
-d --directories-file-path  path to file with list of local directories on each line

";

$argumentos = getopt("n:d:", array(
    "name:",
    "directories-file-path:"
));

//If the options are not set, we exit and indicate the usage mode.
if (
    !(isset($argumentos["d"]) || isset($argumentos["name"]))
    ||
    !(isset($argumentos["d"]) || isset($argumentos["directories-file-path"]))
) {
    exit($help);
}

//All options are well established until here
$name = isset($argumentos["n"]) ? $argumentos["n"] : $argumentos["name"];
$directoriesFilePath = isset($argumentos["d"]) ? $argumentos["d"] : $argumentos["directories-file-path"];
echo "automate-check" . PHP_EOL;
echo "Searches for repositories with changes." . PHP_EOL;
echo "name: $name" . PHP_EOL;
echo "directories file path: $directoriesFilePath" . PHP_EOL;
print_r(checkName($name, $directoriesFilePath));




