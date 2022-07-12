<?php
$ayuda="automate-check
Searches for repositories with changes
Usage:
-r --ruta               path to a git
-c --commit             a commit Id
-b --branch             the branch where the commit was made
-d --directories        path to file with list of local directories on each line
";

$argumentos = getopt("r:c:b:d:", array(
    "ruta:",
    "commit:",
    "branch:",
    "directories:"
));

//If the options are not set, we exit and indicate the usage mode.
if (
    !(isset($argumentos["r"]) || isset($argumentos["ruta"]))
    ||
    !(isset($argumentos["c"]) || isset($argumentos["commit"]))
    ||
    !(isset($argumentos["b"]) || isset($argumentos["branch"]))
    ||
    !(isset($argumentos["d"]) || isset($argumentos["directories"]))
) {
    exit($ayuda);
}

//All options are well established until here
$ruta = isset($argumentos["r"]) ? $argumentos["r"] : $argumentos["ruta"];
$commit = isset($argumentos["c"]) ? $argumentos["c"] : $argumentos["commit"];
$branch = isset($argumentos["b"]) ? $argumentos["b"] : $argumentos["branch"];
$directories = isset($argumentos["d"]) ? $argumentos["d"] : $argumentos["directories"];
echo "automate-check" . PHP_EOL;
echo "Searches for repositories with changes." . PHP_EOL;
echo "ruta: $ruta" . PHP_EOL;
echo "commit: $commit" . PHP_EOL;
echo "branch: $branch" . PHP_EOL;
echo "directories: $directories" . PHP_EOL;

