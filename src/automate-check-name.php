<?php

require_once('Automate.php');

$ayuda="automate-check-name
Searches for repositories with changes
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
    exit($ayuda);
}

//All options are well established until here
$name = isset($argumentos["n"]) ? $argumentos["n"] : $argumentos["name"];
$directoriesFilePath = isset($argumentos["d"]) ? $argumentos["d"] : $argumentos["directories-file-path"];
echo "automate-check" . PHP_EOL;
echo "Searches for repositories with changes." . PHP_EOL;
echo "name: $name" . PHP_EOL;
echo "directories file path: $directoriesFilePath" . PHP_EOL;
print_r(checkName($name, $directoriesFilePath));




