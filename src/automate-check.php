<?php
$ayuda="automate-check
Busca repositorios con cambios
Modo de uso:
-r --ruta               ruta a un git
-c --commit             un commit Id
-b --branch             la branch donde se ha hecho el commit
-d --directorios        ruta a archivo con lista de directorios locales en cada linea 
";

$argumentos = getopt("r:c:b:d:", array(
    "ruta:",
    "commit:",
    "branch:",
    "directorios:"
));
// Las opciones deben estar establecidas
// Si no, salimos e indicamos el modo de uso
if (
    !(isset($argumentos["r"]) || isset($argumentos["ruta"]))
    ||
    !(isset($argumentos["c"]) || isset($argumentos["commit"]))
    ||
    !(isset($argumentos["b"]) || isset($argumentos["branch"]))
    ||
    !(isset($argumentos["d"]) || isset($argumentos["directorios"]))
) {
    exit($ayuda);
}

// Hasta aquí todas las opciones están bien establecidas
$ruta = isset($argumentos["r"]) ? $argumentos["r"] : $argumentos["ruta"];
$commit = isset($argumentos["c"]) ? $argumentos["c"] : $argumentos["commit"];
$branch = isset($argumentos["b"]) ? $argumentos["b"] : $argumentos["branch"];
$directorios = isset($argumentos["d"]) ? $argumentos["d"] : $argumentos["directorios"];
echo "automate-check" . PHP_EOL;
echo "Buscando repositorios con cambios." . PHP_EOL;
echo "ruta: $ruta" . PHP_EOL;
echo "commit: $commit" . PHP_EOL;
echo "branch: $branch" . PHP_EOL;
echo "directorios: $directorios" . PHP_EOL;

