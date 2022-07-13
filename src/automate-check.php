<?php

require_once('Automate.php');

$ayuda="automate-check
Searches for repositories with changes
Usage:
-r --repositorie-path       path to a git folder
-c --commit                 a commit Id
-b --branch                 the branch where the commit was made
-d --directories-file-path  path to file with list of local directories on each line
";

$argumentos = getopt("r:c:b:d:", array(
    "repositorie-path:",
    "commit:",
    "branch:",
    "directories-file-path:"
));

//If the options are not set, we exit and indicate the usage mode.
if (
    !(isset($argumentos["r"]) || isset($argumentos["repositorie-path"]))
    ||
    !(isset($argumentos["c"]) || isset($argumentos["commit"]))
    ||
    !(isset($argumentos["b"]) || isset($argumentos["branch"]))
    ||
    !(isset($argumentos["d"]) || isset($argumentos["directories-file-path"]))
) {
    exit($ayuda);
}

//All options are well established until here
$repositoriePath = isset($argumentos["r"]) ? $argumentos["r"] : $argumentos["repositorie-path"];
if (substr($repositoriePath, -1)!="/"){
    $repositoriePath  = $repositoriePath . "/";
}

$commit = isset($argumentos["c"]) ? $argumentos["c"] : $argumentos["commit"];
$branch = isset($argumentos["b"]) ? $argumentos["b"] : $argumentos["branch"];
$directoriesFilePath = isset($argumentos["d"]) ? $argumentos["d"] : $argumentos["directories-file-path"];
echo "automate-check" . PHP_EOL;
echo "Searches for repositories with changes." . PHP_EOL;
echo "repositorie path: $repositoriePath" . PHP_EOL;
echo "commit: $commit" . PHP_EOL;
echo "branch: $branch" . PHP_EOL;
echo "directories file path: $directoriesFilePath" . PHP_EOL;

echo "changes: " . PHP_EOL;
print_r(check($repositoriePath, $commit, $branch, $directoriesFilePath));




