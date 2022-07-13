<?php
require_once('Composerfiles.php');

$ayuda="automate-composer-gen
Generates repository files for testing.
Usage:
-r --repositories-path  a folder path where the generated test repositories will be saved
-d --directories-file-path saves the paths of the generated repositories in a file, this file is required to run automate-check
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
    exit($ayuda);
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

$repositories = generateComposer();
$repositories_file = saveComposer($repositories, $repositoriesPath);
saveFile($directoriesFilePath, $repositories_file);

echo "files created successfully." . PHP_EOL;
