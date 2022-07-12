<?php
$ayuda="automate-check-composer
Given the name of a composer.json, identify which other composer.json include it, both directly and indirectly.
Usage:
-n --name             name of a composer.json
-d --directories        path to file with list of local directories on each line
";

$argumentos = getopt("n:d:", array(
    "nombre:",
    "directorios:"
));

//If the options are not set, we exit and indicate the usage mode.
if (
    !(isset($argumentos["n"]) || isset($argumentos["nombre"]))
    ||
    !(isset($argumentos["d"]) || isset($argumentos["directories"]))
) {
    exit($ayuda);
}

//All options are well established until here
$nombre = isset($argumentos["n"]) ? $argumentos["n"] : $argumentos["nombre"];
$directories = isset($argumentos["d"]) ? $argumentos["d"] : $argumentos["directories"];
echo "automate-check-composer" . PHP_EOL;
echo "Buscando otros composer.json que lo incluyen, tanto de forma directa como indirecta." . PHP_EOL;
echo "nombre: $nombre" . PHP_EOL;
echo "directories: $directories" . PHP_EOL;

